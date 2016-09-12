## osSelect
The `osSelect` directive allows you to create a dropdown list with your model data and given selected value.
The model data should be an object array, each object has two property: textField and valueField.
The given selected value will be used to display as the selected item.
---

## Directive Info
This directive executes at priority level 0.

---

## Usage
as attribute:
```
<ANY
    os-select
    items=""
    ng-model=""
    [dropdown-width=""]
    [text-field=""]
    [value-field=""]
    [on-change=""]
    [direction=""]
    [type=""]
    [is-disabled=""]
    [default-text=""]
    [error-message=""]
    [no-default-choice=""]
    [without-tooltip=""]
    >
</ANY>
```
as element
```
<os-select
    items=""
    ng-model=""
    [dropdown-width=""]
    [text-field=""]
    [value-field=""]
    [on-change=""]
    [direction=""]
    [type=""]
    [is-disabled=""]
    [default-text=""]
    [error-message=""]
    [no-default-choice=""]
    [without-tooltip=""]
</os-select>
```

---

## Arguments
Param | Type | Default | Details
----- | ---- | ------- | ----
items                        | `expression` | []        | Set the data of object array([{textField:"value1", valueField:"value2"}]) to data-bind to.
textField (*optional*)       | `string`     | 'text'    | Property of select item object.
valueField (*optional*)      | `string`     | 'value'   | Property of select item object.
onChange (*optional*)        | `expression` |           | Angular expression to be executed when the selected item changed
ngModel (*optional*)         | `string`     | ''        | Value of selected item valueField.
dropdownWidth (*optional*)   | `string`     |''         | Width of dropdown
direction (*optional*)       | `string`     | ''        | Set dropdown-list's display position. If direction="up", dropdown list will be displayed on the top of parent element, else displayed on the bottom.
type (*optional*)            | `string`     | ''        | According to this type set the type of dropdown list, including icon, iconText, detail and default.
isDisabled (*optional*)      | `boolean`    | false     | Set the dropdown-list disabled.
defaultText (*optional*)     | `string`     | undefined | If the ngModel is invalid, set the defaultText value as selected item
errorMessage (*optional*)     | `string`     | undefined | Display error message below select box
noDefaultChoice (*optional*)  | `string`     | ''        | Do not need default choice as 'Please Selcet'

## Example
html
```
<div os-select
  items="follower.genderOptions" text-field="text" value-field="value" on-change="follower.changeGender" ng-model="follower.gender" direction="up" type="iconText" is-disabled="false" default-text="{{'channel_wechat_mass_male' | translate}}" error-message="follower.errorMessage" no-default-choice="false" dropdown-width="400px">
</div>
```

coffee
```
follower =
  genderOptions: [
      text: "channel_wechat_mass_unlimited"
      value: 0
    ,
      text: "channel_wechat_mass_male"
      value: "MALE"
    ,
      text: "channel_wechat_mass_female"
      value: "FEMALE"
    ,
      text: "unknown"
      value: "UNKNOWN"
  ]

  # If you want to select default choice, you should set the value as -1
  gender = -1

  changeGender = (gender, idx) ->
    vm.params.gender = gender
    vm.genderText = vm.genderOptions[idx].text
    return

  save = ->
    # If the select is required field and the user did not select one item, you should set error message
    if gender is -1
      errorMessage = 'required_field_tip'
    else
      # submit
```

type = detail

```
<div os-select type="detail" ng-model="broadcast.object" text-field="text" value-field="value" items="broadcast.objectItems"></div>
```

```coffee
vm.objectItems = [
  value: 'all',
  text: 'channel_wechat_mass_all'
  detail: '<b>库存:20</b>'
,
  value: 'tag',
  text: 'channel_wechat_mass_tag'
  detail: '库存:40'
]
vm.object = -1 # 默认选中“请选择”
```