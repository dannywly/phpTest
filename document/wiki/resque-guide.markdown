# OmniSocials Resque Job

## Module Development

You can get a brief introduction about resque job defined in module [here](http://git.augmentum.com.cn/scrm/aug-marketing/blob/develop/document/wiki/how-to-develop-plugin.markdown#resque-job)

## Jobs

### Job Types

+ **immediate job**:  Execute immediately
+ **delayed job**:  Execute at specified time
+ **schedule job**: Execute with specified intervals

### Job Definition

Each job should define its own class, and contain a `perform` method.

```php
class Job_MyJob extends BaseJob
{
    public function perform()
    {
        echo $this->args['name'];
        // TODO
    }
}
```

For delayed and schedule job, the job class must extend `backend\components\resque\SchedulerJob`.

```php
use backend\components\resque\SchedulerJob;

class Job_MyJob extends SchedulerJob
{
    public function perform()
    {
        echo $this->args['name'];
        // TODO
    }
}
```

When the job is executed, the class will be instantiated and all the arguments
passed as method parameter (`create` method of job component) or array field (returned as an item of `setScheduleJob` in `Module` class) can be accessible
via `$this->args`.

Jobs have `setUp` and `tearDown` methods. If a `setUp` method is defined, it will be called before the `perform` method is run. The `tearDown` method, if defined, will be called after the job finishes.

```php
class My_Job
{
    public function setUp()
    {
        // ... Set up environment for this job
    }

    public function perform()
    {
        // .. Run job
    }

    public function tearDown()
    {
        // ... Remove environment for this job
    }
}
```

**Notice:** Any exception thrown by a job will make the job failed - be
careful here and make sure you handle the exceptions that shouldn't
make the job failed.

### Create Job with `job` Component

The `create` method of job service use the parameters below:

```php
public function create($className, $args = [], $executeTime = null, $interval = null)
```

Paramters description:

* **className:** string, job name with full namespace
* **args:** array, arguments passed to job
* **executeTime:** int(UNIX timestam), job executed time
* **interval:** int, interval time using second as unit

#### Create Immediate Job

```php
Yii::$app->job->create('Job_Class', $args = []);
```

For example:

```
$jobArgs = [
    'channelId' => $channelId,
];
$jobClass = 'backend\modules\member\job\Birthday';
$jobId = Yii::$app->job->create($jobClass, $jobArgs);
```

#### Create Delayed Job

You can run job at specified time

```php
Yii::$app->job->create('Job_Class', $args = [], $excutedAt = time());
```

For example: execute job `Birthday` 5 minutes later

```
$jobArgs = [
    'channelId' => $channelId,
];
$jobClass = 'backend\modules\member\job\Birthday';
$jobId = Yii::$app->job->create($jobClass, $jobArgs, strtotime("+5 minutes"));
```

#### Create Scheduler Job

```php
Yii::$app->job->create('Job_Class', $args = [], $excutedAt = time(), $interval);
```

For example: execute job `Birthday` at *01:00:00* every day

```
$jobArgs = [
    'channelId' => $channelId,
];
$jobClass = 'backend\modules\member\job\Birthday';
$jobId = Yii::$app->job->create($jobClass, $jobArgs, strtotime(date('Y-m-d 01:00:00')), TimeUtil::SECONDS_OF_DAY);
```

### Getting Job Status

You can use `status` method defined in `job` component to get the status of a job by using job token when creating, you can check if a job is queued, running, finished, or failed.

```php
$token = Yii::$app->job->create('Job_Class', ['name' => 'QunCRM']); // Example: ba1dfb1e2f20a938cbbe5accfd4a845d
Yii::$app->job->status($token);
```

Job statuses are defined as constants in the `Resque_Job_Status` class in `src/backend/modules/resque/components/lib/Resque/Job/Status.php` file.

Valid statuses include:

* `Resque_Job_Status::STATUS_WAITING` - 1, Job is still queued
* `Resque_Job_Status::STATUS_RUNNING` - 2, Job is currently running
* `Resque_Job_Status::STATUS_FAILED` - 3，Job has failed
* `Resque_Job_Status::STATUS_COMPLETE` - 4， Job is complete
* `false` - The token is invalid

Statuses are available for up to 24 hours after a job has completed
or failed, and are then automatically expired.


## Workers

Worker just like a consumer, get a job from resque queue and execute it. Make sure you start more than a worker manually or with supervisor. (Job can only be executed after a worker is started).

* Start a worker manually

```
# Start a normal worker
php {project_path}/src/backend/modules/resque/components/bin/resque

# Start a scheduler worker
php {project_path}/src/backend/modules/resque/components/bin/resque-scheduler
```

* Start a worker with supervisor can be found below in **Use supervisor** section

### Pass Environment Parameters to Worker

You can pass environment parameters to worker to define its behavior.

* Set target queue name which the worker will check for

```sh
 QUEUE=default
```
This option default to `*` means all queue.

* Set interval time

```sh
INTERVAL=[time in second]
```
Set time interval for checking new job.

* Run in logging mode

```sh
VERBOSE=[1 or 0]
LOGGING=[1 or 0]
```

Set either `VERBOSE` or `LOGGING` to be `1`, if you want to see normal logs in log file.

* Detailed logs

```sh
VVERBOSE=[1 or 0]
```

Set `VVERBOSE` to be `1`, if you want to see more detailed logs in log file.

* Number of worker

```sh
COUNT=[integer]
```

### Use PHP Command

You can pass environment variables before executing the command, every environment variable following key value pair pattern and divide with `comma` like the example below:

```
QUEUE=global,LOGGING='1'
```

* Start workers and make it listen on the global queue.

```sh
QUEUE=global,LOGGING='1' php {project_path}/src/backend/modules/resque/components/bin/resque
```
This is used for consuming immediate job and delayed job.

* Start workers and make it listen on the global queue

```sh
QUEUE=global php {project_path}/src/backend/modules/resque/components/bin/resque-scheduler
```
This is used for consuming scheduler job.

**Notice:** `resque` and `resque-scheduler` are binary files for starting a worker, `{project_path}` should be replaced with real project root path.

### Use Supervisor to Start Worker

Add following content to [supervisor](http://supervisord.org/) config file, eg: `/etc/supervisor/conf.d/wm.conf`,  then restart supervisor.

```sh
[program:scheduler]
process_name=%(program_name)s_%(process_num)02d
directory={project_path}
command=php {project_path}/src/backend/modules/resque/components/bin/resque-scheduler
numprocs=1
redirect_stderr=True
autostart=True
autorestart= True
environment=QUEUE='global',LOGGING='1',APP_INCLUDE='{project_path}/src/backend/modules/resque/components/lib/Resque/RequireFile.php'
stdout_logfile=/var/log/supervisor/%(program_name)s-stdout.log
stderr_logfile=/var/log/supervisor/%(program_name)s-stderr.log

[program:global]
process_name=%(program_name)s_%(process_num)02d
directory={project_path}
command=php {project_path}/src/backend/modules/resque/components/bin/resque
numprocs=1
redirect_stderr=True
autostart=True
autorestart= True
environment=QUEUE='global',LOGGING='1',APP_INCLUDE='{project_path}/src/backend/modules/resque/components/lib/Resque/RequireFile.php'
stdout_logfile=/var/log/supervisor/%(program_name)s-stdout.log
stderr_logfile=/var/log/supervisor/%(program_name)s-stderr.log

[program:backend]
process_name=%(program_name)s_%(process_num)02d
directory={project_path}
command=php {project_path}/src/backend/modules/resque/components/bin/resque
numprocs=1
redirect_stderr=True
autostart=True
autorestart= True
environment=QUEUE='backend',LOGGING='1',APP_INCLUDE='{project_path}/src/backend/modules/resque/components/lib/Resque/RequireFile.php'
stdout_logfile=/var/log/supervisor/%(program_name)s-stdout.log
stderr_logfile=/var/log/supervisor/%(program_name)s-stderr.log

```

**Notice:** `(program_name)`, `(process_num)` and `{project_path}` should be replace with proper value.
