## wmCopy
The `wmCopy` directive allows you to copy url content to clipboard by clicking the icon.

---

## Directive Info
This directive executes at priority level 0.

---

## Usage
as attribute:
```
<ANY
    wm-copy
    clipboard-text="" tip="{{'hover_tip' | translate}}">
</ANY>
```
---

## Arguments
Param | Type | Default | Details
----- | ---- | ------ | ----
clipboardText              | `string` | '' | Set the url content that will copied to the clipboard.
tip              | `string` | '' | Show help tip when hover the copy component

---

## Example
html
```
<i wm-copy clipboard-text="url" tip="{{'hover_tip' | translate}}"></i>
```

coffee
```
url = "http://u.augmarketing.com/BPyA"
```
