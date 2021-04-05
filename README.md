
## Pangaea Take-home assignment

For this challenge we'll be creating a HTTP notification system. A server (or set of servers) will keep track of topics -> subscribers where a topic is a string and a subscriber is an HTTP endpoint. When a message is published on a topic, it should be forwarded to all subscriber endpoints.


## Setup Instruction
composer install
setup your env variables
php artisan migrate --seed


## Endpoints
 POST /subscribe/{topic}
 expected body {url: string}
 response { url: string, topic: string }

 POST /publish/{topic}
 expected body { [key: string]: any }

## Testing
php artisan test


