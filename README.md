# Public Holiday

This project is created to ease anyone who is looking for all declared public holiday in Malaysia. It utilize [Calendarific](https://calendarific.com/) data on Malaysia's public holiday.
This project is initiated by me for using in my company project which use public holiday for counting processing working days in Malaysia

## Installation

Clone the project at 

```bash
git clone https://github.com/muaz234/MuazLabs-PublicHoliday-Malaysia.git
```

Then, ensure you have environment PHP 7.0 above with Apache web server configured and MySQL 5.7 above. Ensure Composer is installed to.

## Usage

1. Create new MySQL database and run `example.sql`.
2. Update your credentials at `connect.php` that suit to your current environment
3. Then, register an account in [Calendarific](https://calendarific.com/) to receive an API key
4. Paste the key in `$token` variable in `credentials.php`
5. Run `composer install` in your local terminal, execute the `holiday.php` script in your preferred browser
5. Open your MySQL database using any 3rd party tools(I am using MySQL Workbench), check the contents of the tables with listed public holidays in Malaysia

## Contributing
Pull requests are welcome. Please read the docs on [GuzzlePHP](https://docs.guzzlephp.org/en/5.3/quickstart.html) or [Carbon](https://carbon.nesbot.com/) if required
You may contact me via [email](mailto:ahmedmuaz0152@gmail.com)  or [Telegram](https://t.me/muaz234) for any discussion or improvement.

## TODO
Add unit testing features inside GuzzlePHP http call. Mocking a call for http and run php unit test if required.

## License
[MIT](https://opensource.org/licenses/MIT)
