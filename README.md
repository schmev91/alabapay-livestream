# Alabapay Livestream Package

## Installation Guide

### Add the package as a repository into `composer.json`

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/schmev91/alabapay-livestream"
        }
    ]
}
```

### Install the package with composer

```bash
composer require alabapay/alabapay-livestream
```

### Run the command below and the package will set itself

```bash
php artisan alabapay-livestream:setup
```

#### With the setup command, the package will:

- Publish `alabapay-livestream.php` to the configs directory.
- Publish a new migration file into the `database/migrations` directory with the suffix `create_alabapay_livestream_tables`.
- Automatically run `php artisan migrate` to migrate the new migration file.

## Environment Variables

`ALABAPAY_LIVESTREAM_KEY`: Your API Key from Alabapay

## Config Parameters

| Parameter       | Type   | Default Value                     | Description                                  |
| --------------- | ------ | --------------------------------- | -------------------------------------------- |
| `access_key`    | string | `env("ALABAPAY_LIVESTREAM_KEY")`  | Your Alabapay Access Key                     |
| `alabapay_url`  | string | `http://genius_alaba.test/`       | URL to Alabapay                              |
| `user_class`    | string | `\App\Models\User::class`         | The User Class's path                        |

## API Reference

### Endpoints Overview

| Method  | Endpoint                         | Description                               |
| ------- | -------------------------------- | ----------------------------------------- |
| GET     | `/api/livestream`                | Retrieve the list of live streaming users |
| POST    | `/api/livestream/generate-token` | Generate Livestream Token                 |
| POST    | `/api/livestream/end`            | End the livestream                        |

---

#### GET `/api/livestream`

**Description:** Retrieve a list of livestreaming users.

#### POST `/api/livestream/generate-token`

**Description:** Generate livestream token.

**Request Body:**  
| Name | Type | Required | Description |
|------------|--------|----------|---------------------------|
| `channelName` | string | yes | The channel name |

#### POST `/api/livestream/end`

**Description:** End the stream.

**Request Body:**  
| Name | Type | Required | Description |
|------------|--------|----------|---------------------------|
| `watching_count` | int | yes | The number of users that are watching the livestream |
| `comment_count` | int | yes | Total comment count |
| `collected_diamond` | int | yes | Diamond collected |
