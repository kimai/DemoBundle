
# A Kimai demo bundle

[![CI Status](https://github.com/Keleo/DemoBundle/workflows/CI/badge.svg)](https://github.com/Keleo/DemoBundle/actions)

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
- a doctrine migration for creating a simple database 
- an installation command (that will be used for future database updates as well) 

### Demo configuration

You users could set a default value via `local.yaml` like this:
```yaml
demo:
    some_setting: testing
```

But that should not be required, as they can change the configuration through the "System configuration" screen in Kimai. 

## Installation

This plugin is compatible with the following Kimai releases:

| Bundle version | Minimum Kimai version |
|----------------|-----------------------|
| 2.0            | 2.0                 |
| 0.9 - 0.10     | 1.11                  |
| 0.9            | 1.11                  |
| 0.8            | 1.10                  |
| 0.5 - 0.7      | 1.7                   |
| 0.1 - 0.4      | 1.6                   |

You find the most notable changes between the versions in the file [CHANGELOG.md](CHANGELOG.md).

Download and extract the [compatible release](https://github.com/Keleo/DemoBundle/releases) in `var/plugins/` (see [plugin docs](https://www.kimai.org/documentation/plugin-management.html)).

The file structure needs to look like this afterwards:

```bash
var/plugins/
├── DemoBundle
│   ├── DemoBundle.php
|   └ ... more files and directories follow here ... 
```

Then rebuild the cache:
```bash
bin/console kimai:reload -n
```

And install the database: 
```bash
bin/console kimai:bundle:demo:install
```

## Permissions

This bundle ships a new permission:

- `demo` - show all demo options to the user 

By default, it is assigned to each user with the role `ROLE_SUPER_ADMIN`.

Read how to assign this permission to your user roles in the [permission documentation](https://www.kimai.org/documentation/permissions.html).
