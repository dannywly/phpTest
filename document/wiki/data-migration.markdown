# Data migration

## Create script
Migration script must be under module folder ***migration***.
You can new a php file extends `BaseMigration` and implements abstract method for run migration code or ***use console command to generate template***.

The command is:
```
./yii migration/create module class
```
+ module
    must be an available module name
+ class
    the php file name, can't be php reserved words, the first character will be uppercased automatically

For example:

```
./yii migration/create content demo
```
It will create a file in `src/backend/modules/content/migration/Demo.php`,
with content:
```
<?php
namespace backend\modules\content\migration;

use backend\components\BaseMigration;

/*
 * This class is create by console/controllers/MigrationController.php
 * Used for module content data migration
 */
class Demo extends BaseMigration
{
    /**
     * This method is used to specify running time(format: Y-m-d H:i).
     * If the returned time is greater than last build time and less than
     * current build time, perform method of the class will be executed.
     * @return string
     */
    public static function getDate()
    {
        return '2016-01-29 15:45';
    }
    
    /**
     * Put your code here
     */
    public function perform()
    {
        echo "Demo run perform.\n";
        // TODO
    }

    public function revert()
    {
        // TODO
        parent::revert();
    }
}
```

## Inheritance relationship
We have SuperClass `BaseMigration`, its a `abstract` class, 
contains methods:

- *abstract public static function getDate()*
- *abstract public function perform()*
- *public function setUp()*
- *public function perform()*
- *public funtioin tearDown()*
- *public function revert()*

So all your migration script file must extend `BaseMigration`, and implements method `getDate` and `perform`


## Migration lifecycle
Migration logic is implemented in the perform method, and follow the executing sequence flow:
```
setUp -> perform -> tearDown
```
So if you want to run code before `perform`, you can overwrite the method `setUp`, and put code here.  Similarly, you can overwrite the method `tearDown` for execute code after `perform`. 

***You should add class doc comment, describe why you write this script, and migrate data for what***

for example:
```
<?php
namespace backend\modules\content\migration;

use backend\components\BaseMigration;

/*
 * Add default picture group for each account.
 */
class AddDefaultGroup extends BaseMigration
{

}
```

We will get a record like that:
```
"content" : [
            {
                "class" : "backend\\modules\\content\\migration\\AddDefaultGroup",
                "comment" : "Add default picture group for each account.",
                "usedTime" : NumberLong(0)
            }
        ]
```

It can help us review all migration and its purpose. So make it as specific as possible.



## Apply migration
We provide console command:
```
./yii migration/perform module class
```
to execute all migration script.

The default value of module and class is null, means scan all modules.
If specify a module, it only execute migration script under this module,
you can also specify a module and a class for executing which one you want.

For examples:
```
# execute all migration scripts
./yii migration/perform

# execute scripts under module `content`
./yii migration/perform content

# execute script of class `addDefaultGroup` under module `content`
./yii migration/perform content addDefaultGroup
```

***We add this console command to build step, and will check whether to run migration script.***

## Migration revert
We don't record anything about database operation, we only record which php script last build executed, and will execute the `revert` method of php script last executed.

***You should put your code under `revert` method, and write your logic to revert.***

we provider console command to revert:
```
./yii migration/revert
```