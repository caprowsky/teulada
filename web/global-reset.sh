#!/usr/bin/env bash

drush sql-drop -y; drush sql-sync @si.dev @self -y; drush updb -y; drush cim -y; drush cr