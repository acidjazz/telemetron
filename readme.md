
# telemetron
> telemetries test case


### requirements
* php v7.x
* Mysql v5.7+
* composer (global install perfered)
* node v12.x (for frontend only)
* yarn v1.16.x (for frontend only)

### installation

* create a database `telemetron` on your local mysql server

* full install TL:DR;
```bash
git clone git@github.com:acidjazz/telemetron.git; cd telemetron/; yarn; composer install; cp .env.example .env; yarn logs; yarn mdi; ./artisan migrate:fresh; ./artisan process:json; yarn apicache;
```
* clone from github
```bash
git clone git@github.com:acidjazz/telemetron.git
```
* run `yarn` and `composer install` to install all of your deps

```bash
cd telemetron/; yarn; composer install
```

* copy `.env.example` to `.env` and configure it to your likings
```bash
cp .env.example .env
```

* run `yarn logs` to create laravels needed storage and `yarn mdi` to copy over the icons file
```bash
yarn logs; yarn mdi
```

* run a fresh migration to get your db populated
```bash
./artisan migrate:fresh
```

* import the json files via the console command
```bash
./artisan process:json
```

* run the front end and backend processes (preferably in seperate terminals)
```bash
yarn dev
```

```bash
yarn api
```
* visit `http://localhost:3000/` to view the data and links to the API endpoints


### API only
* just solely run `yarn api` and then visit http://localhost:8000/ for a route dump
* endpoints are `http://localhost:8000/api/flight` and `http://localhost:8000/api/flight/{id}`


## technology stack
<p align="center">
  <a href="https://laravel.com"><img src="https://onecentlin.gallerycdn.vsassets.io/extensions/onecentlin/laravel-extension-pack/0.4.0/1534522609664/Microsoft.VisualStudio.Services.Icons.Default"  width="128" height="128"/></a>
  <img src="https://raw.githubusercontent.com/acidjazz/aeonian/master/media/plus.png"/>
  <a href="https://nuxtjs.org/"><img src="https://images.opencollective.com/proxy/images?src=https%3A%2F%2Fopencollective-production.s3-us-west-1.amazonaws.com%2F63047830-23b9-11e9-8073-c73f9d8c047d.png&height=480"  width="128" height="128"/></a>
</p>

<p align="center">
  <a href="https://vuejs.org"><img src="https://vuejs.org/images/logo.png" width="92" height="92" /></a>
  <a href="https://tailwindcss.com"><img src="https://pbs.twimg.com/profile_images/895274026783866881/E1G1nNb0_400x400.jpg" width="92" height="92" /></a>
  <a href="https://github.com/acidjazz/metapi"><img src="https://github.com/acidjazz/metapi/raw/master/logo.png" width="92" height="92" /></a>
  <a href="https://materialdesignicons.com"><img src="https://lh3.googleusercontent.com/kellzw4-4Q258D_HdHvcclbu2HEheO1TxauO4lmI5T6tCDnk8pvUfh0W0WpvKiB54g=s96-rw" width="92" height="92" /></a>
</p>

[laranuxt](https://github.com/acidjazz/laranuxt)

