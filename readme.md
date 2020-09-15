# Magento Test

A new module (Luis_MagentoTest) was created in order to fulfil the tasks

## Task #1

- (Only for CMS pages) Block added to the header: `\Luis\MagentoTest\Block\Cms\HeadHrefLang`
- Template: `app/code/Luis/MagentoTest/view/frontend/templates/href-lang.phtml`

## Task #2

The idea was to save the color options in the settings (`core_config_data`). 
In this way, we can change it via admin and via console command.

![](https://i.ibb.co/NydqQg2/Screen-Shot-2020-09-15-at-11-01-03-PM.png)

### Console Command
```bash
bin/magento scandiweb:color-change --text-color=FFFFFF --bg-color=12e8d7 --store-id=2
```

In the front-end, the `app/code/Luis/MagentoTest/view/frontend/templates/styling.phtml` is getting these settings and 
applying the styling to the `.action.primary` CSS selector.  
 
### Task #3

The solution was to use the Layout Processor to handle the fields, and a JS mixin to change the button behavior.

![](https://i.ibb.co/4MpTCZy/Screen-Shot-2020-09-15-at-11-06-58-PM.png)