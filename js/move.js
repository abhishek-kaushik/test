/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var imgObj = null;
var animate ;
function init(){
   imgObj = document.getElementById('myImage');
   imgObj.style.position= 'relative'; 
   imgObj.style.left = '0px'; 
   imgObj.style.top =  '0px';
}
 var right  =    function moveRight(){
   imgObj.style.left = parseInt(imgObj.style.left) + 10 + 'px';
   animate = setTimeout(moveRight,20); // call moveRight in 20msec
}
if(imgObj.style.left == '200px')
{    
function stop(){
   clearTimeout(animate);
   imgObj.style.left = '0px';} 
}
window.onload =init;




