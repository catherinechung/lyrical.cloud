lyrical.cloud
=============

*What are your favorite artists really saying?*

lyrical.cloud is a web-based application that can generate a colorful and fun word cloud of artists' most used lyrics.

## Table of Contents

- [Purpose](#purpose)
- [Installation](#installation)
- [License](#license)

## Purpose
 The objective of this web service is to provide a fast, coherent, and visually appealing representation of a given artist’s/artists’ lyrics, formatted as a word cloud and based on frequency count. 
The main functionality of the application is centered around the generation of word clouds based on the lyrics of a single artist.

Additional functionality consists of:
- The ability to share a word cloud to Facebook in a graphical format
- Merge the lyrics of another artist into a currently-displaying word cloud
- Explore the frequency of a certain word within the total discography of a certain artist/artists
- Identify the usage of a certain word within a specific song 

The web application will be freely available to any user with Internet access, a computer or mobile phone, and a browser that supports a JavaScript runtime engine. 

## Installation
To run the system, open up a terminal window and navigate to the lyrical.cloud folder.

```cd server```

```php composer.phar install```

```php composer.phar start```

Open up a second terminal window and again, navigate to the lyrical.cloud folder.

```sudo apt-get install nodejs-legacy```

```sudo apt-get install npm```

```npm install -g http-server```

```cd frontend```

```http-server```

Finally, open up any browser and type in `localhost:8081`

## License
MIT License: [LICENSE](https://github.com/catherinechung/lyrical.cloud/blob/master/License.md).

