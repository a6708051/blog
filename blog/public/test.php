<?php
printf('%0.20f', 0.1+0.71191);
echo "<br />";
echo number_format(ceil((0.1+0.71191)*10000)/10000, 4);
echo '=====';
echo number_format(ceil((0.8120)*10000)/10000, 4);
echo '=====';
echo number_format(ceil((0.8120)*100000)/100000, 4);
echo "<br />";
echo bcadd(0.1, 0.71191, 20);
echo "<br />";
echo number_format(0.8120 + 4/pow(10, 4+1), 4);
echo "<br />";
echo number_format(0.81191 + 4/pow(10, 4+1), 4);
