#!/bin/bash
chown -R www-data:www-data public/molfiles 

cp checkmol /usr/local/bin
cp mol2svg /usr/local/bin

cd /usr/local/bin
ln checkmol matchmol
chmod 755 mol2svg
