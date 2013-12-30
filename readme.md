Drupal Release Date
===================

System for tracking issue counts against the next version of Drupal core, and
estimating a release date based on collected samples.

Access the site at http://drupalreleasedate.com/


## Data API ##

Public JSON feeds are provided for access to all of the site's data.

*__Note__: This project is still in active development, and so the data response
format is subject to change at any time, though backwards compatibility will be
maintained as best as possible.*


### Endpoints ###

__/data/samples.json__

```
[
    {
        "when": "2013-05-29 12:35:00",
        "critical_bugs": 26,
        "critical_tasks": 46,
        "major_bugs": 125,
        "major_tasks": 157,
        "normal_bugs": null,
        "normal_tasks": null
    }
]
```


__/data/estimates.json__

```
[
    {
        "when": "2013-05-31 08:46:00",
        "estimate": "2013-08-24 04:35:22"
    }
]
```

### JSONP ###

To get a response as JSONP, specify a `callback` parameter in the request.
For example: `/data/samples.json?callback=samples_jsonp_callback`
