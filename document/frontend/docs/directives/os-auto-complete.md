## osAutoComplete

## Directive Info
This directive is used to auto complete with user's input and executes at priority level 0.

## Usage
as attribute:
```
<ANY
  os-auto-complete
  ng-model=""
  [input-value=""]
  [one-tag=""]
  [placeholder=""]
  [maxlength=""]
  [add-new-tags=""]
  [error-message=""]
  [localdata=""]
  [callback-url=""]
  [search-key=""]>
</ANY>
```

as element:
```
<os-auto-complete
  ng-model=""
  [input-value=""]
  [one-tag=""]
  [placeholder=""]
  [maxlength=""]
  [add-new-tags=""]
  [error-message=""]
  [localdata=""]
  [callback-url=""]
  [search-key=""]>
</os-auto-complete>
```

## Arguments
Param | Type | Default | Details
----- | ---- | ------  | ------
ngModel                 | **expression** | []    | Tags of input
inputValue              | **expression** | ""    | User enter text in input widget
localdata(*optional*)   | **expression** | []    | Data of array in select box
callbackUrl(*optional*) | **string**     | ''    | Api url for getting data to display in select box
searchKey(*optional*)   | **string**     | ''    | Search key of api
oneTag(*optional*)      | **string**     | ''    | Only need enter one tag value or more('true' or 'false')
placeholder(*optional*) | **string**     | ''    | Show placeholder in component
maxlength(*optional*)   | **string**     | ''    | Max length of every tag
addNewTags(*optional*)  | **string**     | ''    | Whether need to add new tag
errorMessage(*optional*)    | **string** | ''    | Display error message below auto complete box


## Example

### Usage 1
Fetch all data in init method to display in select box

html
```
<div os-auto-complete localdata="broadcast.autoCompleteItems" ng-model="broadcast.tags" maxlength="30" add-new-tags="true" error-message="broadcast.tagError" input-value="broadcast.value">
```
coffee
```
broadcast.autoCompleteItems = [
  '阳光'
  '金卡'
]
# If not fill tags and you should display error message, you should add the code as below
broadcast.tagError = 'required_filed_tip'

```

### Usage 2
Use api to fetch data with user's input and display in select box

html
```
<div os-auto-complete callback-url="/api/member/member/card-number" search-key="number" ng-model="score.numbers"></div>
```

