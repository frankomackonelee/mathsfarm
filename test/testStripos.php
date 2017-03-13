<!DOCTYPE html>
<html>
<body>

<?php
$text = 'Test witout inverted quotes started and ended with single inverted comma';
echo $text . "<br>";
$text = "'" . $text . "'" ;
echo $text . "<br>";
$text = "Test witout inverted quotes started and ended with single inverted comma";
echo $text . "<br>";
$text = "'" . $text . "'" ;
echo $text . "<br>";
echo "Position" . strpos("'what is going on'","'") . "<br>";
echo "First position" . strrpos("'what is going on'","'") . "<br>";
echo "Last position" . stripos("'what is going on'","'") . "<br>";
echo "Position" . strpos('what is going on',"'") . "<br>";
echo "First position" . strrpos('what is going on',"'") . "<br>";
echo "Last position" . stripos('what is going on',"'");
echo "Position" . strpos("what is going on","'") . "<br>";
echo "First position" . strrpos("what is going on","'") . "<br>";
echo "Last position" . stripos("what is going on","'");
?> 

</body>
</html>