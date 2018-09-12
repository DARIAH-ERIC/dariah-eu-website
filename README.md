# DARIAH WordPress Theme

Based on TheFox WP Theme

## Install npm

* `npm install`

## Gulp

* `gulp sass` Create css files
* `gulp js` Create js file
* `gulp watch` Watch files modifications 

## Map
For creating json file:

* Download shape file in [World Borders Dataset](http://thematicmapping.org/downloads/world_borders.php)
* With [GDAL](http://www.gdal.org/ogr2ogr.html), simplify data: `ogr2ogr -select "ISO3" -where "ISO3='AUT' OR ISO3='BEL' OR ISO3='HRV' OR ISO3='CYP' OR ISO3='DNK' OR ISO3='FIN' OR ISO3='FRA' OR ISO3='DEU' OR ISO3='GRC' OR ISO3='IRL' OR ISO3='ITA' OR ISO3='LUX' OR ISO3='MLT' OR ISO3='NLD' OR ISO3='NOR' OR ISO3='POL' OR ISO3='PRT' OR ISO3='SRB' OR ISO3='SVN' OR ISO3='SWE' OR ISO3='CHE' OR ISO3='GBR' OR ISO3='ISR' OR ISO3='CZE'" -f GeoJSON -lco COORDINATE_PRECISION=2 "europe-panes.js" "TM_WORLD_BORDERS-0.3.shp"`
* Add `var euCountries` to begin of file
* Don't forget to minify result

You can find country iso3 code [here](http://www.nationsonline.org/oneworld/country_code_list.htm)

The mandatory `dynamic-data.json` file is created/updated when you create/edit a country, an institution, a person or
 a project.