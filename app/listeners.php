<?php

Event::listen('movies.new_movie', 'ListenersController@newMovie', 1); //priority higher the number greater the prority