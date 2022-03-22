<?php

// end the session by logging out:
session_start();
session_unset();
header('location: ../');

?>
