=== Plugin Name ===
Contributors: Alex Gonzales
Tags: google maps, post, user, marker, coordinates, latitude, longitude
Requires at least: 3.0
Tested up to: 3.0
Stable tag: trunk

Simple GoMaps is a Wordpres Plugin that allows insert map of Google Maps in user profile or admin post, for obtain the coordinates.

== Description ==

This plugin put a map of Google Maps with a custom field that will contain the coordinates of marker.  It can use when the administrator want obtain some ubication.

**In Spanish:**

Este plugin pone un mapa de Google Maps con un campo personalizado que contendra la coordenadas del marcador. Se puede utilizar cuando el administrador desea obtener alguna ubicacion.

== Installation ==

1. Download the plugin
2. Unzip it in /wp-content/plugins/
3. Active the plugin through the 'Plugins' menu in WordPress.
4. Ready!

== Frequently Asked Questions ==

= Why I need a API? =

Cause this plugin work with the version 2

= How it work ? =

It save coordinates in a custom field called "pto_gomaps".

= How can I show it in my theme ? =

If you use it in Admin Post, you can use :

`<?php get_post_meta($post->ID,'pto_gomaps', true) ?>` in Loop.

If you use it in User Profile, you can use :

`<?php the_author_meta('pto_gomaps',$user->ID) ?>`

== Screenshots ==

http://blog.gopymes.pe/wordpress-plugin-simple-gomaps-1-0/

== Changelog ==

= 1.0 =
* It can showing in User Profile or Admin Post.