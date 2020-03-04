# A Kimai 2 demo bundle

A Kimai 2 plugin, which showcases some developer options within Kimai 2.

## What's included?

- a new System configuration
- a new menu entry
- a demo controller with a view and repository
- a new permission
- a theme event, adding a css rule for "magic color dots" (customers, projects, activities)
- a new API method
- a new invoice template (plus a new search path via bundle extension)
- a new dashboard widget 
- a event subscriber to sort the bundle permissions in a new section (see user roles & permission screen) 
- a listener to attach new action items in the plugin screen 
- a meta field for timesheets 
- a user preference

### Demo configuration

You users could set a default value via `local.yaml` like this:
```yaml
demo:
    some_setting: testing
```

But that should not be required, as they can change the configuration through the "System configuration" screen in Kimai. 

## Installation

First clone it to your Kimai installation `plugins` directory:
```
cd /kimai/var/plugins/
git clone https://github.com/Keleo/DemoBundle.git
```

And then rebuild the cache: 
```
cd /kimai/
bin/console cache:clear
bin/console cache:warmup
```

## Permissions

This bundle ships a new permission:

- `demo` - show all demo options to the user 

By default, it is assigned to each user with the role `ROLE_SUPER_ADMIN`.

Read how to assign these permission to your user roles in the [permission documentation](https://www.kimai.org/documentation/permissions.html).
