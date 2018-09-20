# Laravel API

## Scheduled Tasks

For scheduling cron jobs with the API you need to add a line to your cron table.
You can edit the cron table with the following command:

```bash
$ crontab -e
```

Now add this line at the end of the cron table:

```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

## License
