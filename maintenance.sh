php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan optimize

php artisan serve

php artisan migrate
php artisan db:seed

chmod -R 775 storage bootstrap/cache


crear el archivo maintenance.sh y pegar el siguiente contenido
#!/bin/bash

PORT=8000

echo "🔧 Limpiando cachés..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear

echo "⚡ Reconstruyendo cachés..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🚀 Optimizando proyecto..."
php artisan optimize

echo "🗄️ Ejecutando migraciones y seeders..."
php artisan migrate --force
php artisan db:seed --force

echo "📂 Ajustando permisos..."
chmod -R 775 storage bootstrap/cache

# Buscar puerto disponible 
while lsof -i:$PORT -sTCP:LISTEN -t >/dev/null 2>&1; do 
	echo "❌ Puerto $PORT ocupado, probando siguiente..." 
	PORT=$((PORT+1)) 
done 

echo "🌐 Levantando servidor en puerto $PORT..." 
php artisan serve --host=127.0.0.1 --port=$PORT


luego se graba en la raiz del proyecto y se da permisos asi
chmod +x maintenance.sh

y despues se puede ejecutar antes de iniciar el proyecto asi
./maintenance.sh


si el proceso de mantenimiento se queda paralizado en cualquier procese se ejecuta esto:

pkill -f "artisan serve"

chmod -R 775 storage bootstrap/cache
chown -R $USER:$USER storage bootstrap/cache

rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*

CACHE_DRIVER=file

php artisan cache:clear
php artisan config:cache

timeout 10s php artisan cache:clear || echo "⚠️ cache:clear tardó demasiado, limpiando manualmente..."
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*


cliente monte sinai
0923734305001		SANISACA ANDRADE KLEBER SEGUNDO
JK INSUMOS HOSPITALARIOS		AVE. CASUARINA SOLAR 6 Y SN



https://www.youtube.com/live/BF4fQlUDC7s

Gregorio
dario.ronquillor0903@gmail.com
Greg030911/*


curso de ia
https://www.youtube.com/live/BF4fQlUDC7s
https://www.youtube.com/live/4Z2KHi8Am-o
https://www.youtube.com/live/N-l4-kEDNJI

FastAPI
https://www.youtube.com/watch?v=PzIF1IAxzaw


ETL (Extrae, Lee, Transforma)
sql python postgres
https://www.youtube.com/watch?v=dfouoh9QdUw

subir archivos
https://madewithlaravel.com/laravel-mediable
https://madewithlaravel.com/intervention-validation
https://madewithlaravel.com/sentry-laravel
https://madewithlaravel.com/laravel-lets-encrypt
https://laravel-mediable.readthedocs.io/en/latest/installation.html


alias de Expresiones del generador de consultas en laravel
https://laravel-news.com/laravel-12-48-0


https://www.youtube.com/watch?v=stJqF3ixcE4
https://www.youtube.com/watch?v=rjdaClIPaVs
https://www.youtube.com/live/SRBOhHrtkyI
https://www.youtube.com/watch?v=SRBOhHrtkyI
https://www.youtube.com/watch?v=VfFTSOlw-WM



Electronica de autos
https://mk3.com/en/
https://scorpio-lk.com/
https://transpondery.com/



https://www.youtube.com/live/93jzsEQ_F4c
https://www.youtube.com/live/0sROHjCRPnk

https://simulator.electude.com/simulator
https://codigosdtc.com/
https://app.docfix.ca/

https://www.youtube.com/live/UG6K0xUUL0o?list=PLhfZeo48UJQJO_rxLTH4rNE8Q81UihVna
(clases dell scanner)
https://www.youtube.com/live/GO0qsmFaEBs
(banqueo de computadora automotriz - motor toyota 5a-fe)
https://www.youtube.com/live/3s7shrWlgj0
(como conectar un cuadro de instrumntos sin el coche)
https://www.youtube.com/live/26R9evuGMFE
(QUE HACER DESPUÉS DE COMPRAR UN ESCÁNER LAUNCH


https://www.youtube.com/live/9UiTod29sC8
https://www.youtube.com/live/P_AcHcYBR90
https://www.youtube.com/live/pD4j8hX5AVM

https://www.youtube.com/live/leVQlSOf40M



osciloscopio
https://www.youtube.com/watch?v=by3gCxJk_m4

https://www.youtube.com/watch?v=D3Pjl5nBhks&list=PLcaT8eNX71QCm6WmGnLNIit9qHk1ioEGc
https://www.youtube.com/watch?v=D3Pjl5nBhks&list=PLcaT8eNX71QCm6WmGnLNIit9qHk1ioEGc
https://www.youtube.com/watch?v=D3Pjl5nBhks&list=PLQbB-1MnWI3KeRIndr-cH2S7Vx_xUwpry
https://www.youtube.com/watch?v=f7p6nIKMYWo
https://www.youtube.com/live/u2daZHUAJBw?list=PLhfZeo48UJQID97TR9WqaYDRFRUKEknNM

