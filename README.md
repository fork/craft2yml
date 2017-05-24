# craft2yml

a craft cms plugin that translates entries and data structures to yml

## Settings

to adjust settings copy [config.php](craft2yml/config.php) to **craft/config/craft2yml.php** and edit the settings.

## Show/download yml file in browser

open your entry url and just append **'.yml'** to it. (this route can be disabled in settings)

## Generate yml file via console

```
craft/app/etc/console/yiic craft2yml saveYml --entryId=2 --targetFile=data.yml
```