# DARIAH WordPress Theme

Based on TheFox WP Theme

## Collaboration
### Git branches (using [git flow](https://nvie.com/posts/a-successful-git-branching-model/))
* ```master``` for production server
* ```develop```/```release branches``` for development server

## Install npm

* `npm install`

## Gulp

* `gulp sass` Create css files
* `gulp js` Create js file
* `gulp watch` Watch files modifications 

## Map
For creating json file:

* Download shape file in [World Borders Dataset](http://thematicmapping.org/downloads/world_borders.php) (See also in `map/gulp/`)
* With [GDAL](http://www.gdal.org/ogr2ogr.html), simplify data: `ogr2ogr -select "ISO3" -where "ISO3='AUT' OR 
ISO3='BEL' OR ISO3='HRV' OR ISO3='CYP' OR ISO3='DNK' OR ISO3='FIN' OR ISO3='FRA' OR ISO3='DEU' OR ISO3='GRC' OR
ISO3='HUN' OR ISO3='IRL' OR ISO3='ITA' OR ISO3='LUX' OR ISO3='MLT' OR ISO3='NLD' OR ISO3='NOR' OR ISO3='POL' OR
ISO3='PRT' OR ISO3='SRB' OR ISO3='SVN' OR ISO3='SWE' OR ISO3='CHE' OR ISO3='GBR' OR ISO3='ROU' OR ISO3='BGR'
OR ISO3='CZE' OR ISO3='SVK' OR ISO3='BIH'" -f GeoJSON -lco COORDINATE_PRECISION=2 "europe-panes.js" 
"TM_WORLD_BORDERS-0.3.shp"`
* Add `var euCountries = ` to begin of file
* Don't forget to minify result: `gulp europeMap`

You can find country iso3 code [here](http://www.nationsonline.org/oneworld/country_code_list.htm)

The mandatory `dynamic-data.json` file is created/updated when you create/edit a country, an institution, a person or
 a project.

 ### Update:
 You can also get the country border coorindates from this repo: https://gist.github.com/mapsam/6197016
 You have to just simply copy the coordinates and insert them into the map/europe-panes.js it has already the leaflet formatting. 
 
## Mandatory automatically created files
In addition to the `dynamic-data.json` files that is created/updated when creating/editing a country,
an institution, a person or a project, the file `build/yearbook.json` are as well. You 
might have to `mkdir build` to create the `build` directory if it is the first time you run the theme.

## Tools and services
The content is fetched from the DH marketplace. The tabs has a description which is inside the actual tools and services page:

```html
<span class="tab-core-description-text" style="display: none;">Mature service owned by DARIAH-ERIC enabling the infrastructure to carry out its mission.</span>

<span class="tab-community-description-text" style="display: none;">Mature service owned by one or more DARIAH partner institutions. These services usually support local capacity building and scientific instrumentation.</span>

```
This two text contains the description text for the Core and for the Community tabs. Please just change the text inside the span element (do not change the visibility) and a jquery code will fetch the values on the first page load and on every tab change.

## Helpdesk
In order to use the [Helpdesk](https://github.com/DARIAH-ERIC/contact-helpdesk), you can either use the full 
shortcode in the page edition:
```html
This is the helpdesk
<!--more-->
[contact-helpdesk]
```
Or add the queue identifier you want to you use in the code:
```html
This is the helpdesk
<!--more-->
[contact-helpdesk page="%page%"]
```
If you leave ```%page%```, it will try to be rewritten with the HTML query string ```?page=``` becoming 
```[contact-helpdesk page="12"]]``` for a request ot the page ```/helpdesk?page=12```
