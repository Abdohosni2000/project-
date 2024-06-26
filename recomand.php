<?php

// function similarity_distance($matrix, $person1, $person2) {
//     if (!is_array($matrix[$person1]) || !is_array($matrix[$person2])) {
//         return 0;
//     }

//     $similar = array();
//     foreach ($matrix[$person1] as $key => $value) {
//         if (array_key_exists($key, $matrix[$person2])) {
//             $similar[$key] = 1;
//         }
//     }
//     if (count($similar) == 0) {
//         return 0;
//     }

//     $sum = 0;
//     foreach ($matrix[$person1] as $key => $value) {
//         if (array_key_exists($key, $matrix[$person2])) {
//             $sum += pow($value - $matrix[$person2][$key], 2);
//         }
//     }
//     return 1 / (1 + sqrt($sum)); // Changed to avoid potential division by zero
// }

// function getRecommantion($matrix, $person) {
//     $total = array();
//     $simsum = array();
//     $ranks = array();

//     foreach ($matrix as $otherperson => $value) {
//         if ($otherperson != $person) {
//             $sim = similarity_distance($matrix, $person, $otherperson);

//             // Debug: Check similarity scores
//             echo "Similarity between $person and $otherperson: $sim<br>";

//             if ($sim <= 0) {
//                 // Print the movies rated by $person and $otherperson
//                 echo "$person's rated movies: ";
//                 print_r($matrix[$person]);
//                 echo "<br>";
//                 echo "$otherperson's rated movies: ";
//                 print_r($matrix[$otherperson]);
//                 echo "<br>";
//                 continue;
//             }

//             foreach ($matrix[$otherperson] as $key => $value) {
//                 if (!array_key_exists($key, $matrix[$person]) || $matrix[$person][$key] == 0) {
//                     if (!array_key_exists($key, $total)) {
//                         $total[$key] = 0;
//                     }
//                     $total[$key] += $matrix[$otherperson][$key] * $sim;

//                     if (!array_key_exists($key, $simsum)) {
//                         $simsum[$key] = 0;
//                     }
//                     $simsum[$key] += $sim;
//                 }
//             }
//         }
//     }

//     // Debug: Print total and simsum arrays
//     echo "Total: ";
//     print_r($total);
//     echo "SimSum: ";
//     print_r($simsum);

//     foreach ($total as $key => $value) {
//         if ($simsum[$key] != 0) {
//             $ranks[$key] = $value / $simsum[$key];
//         } else {
//             $ranks[$key] = 0; // Handle the case where $simsum[$key] is zero
//         }
//     }

//     array_multisort($ranks, SORT_DESC);

//     return $ranks;
// }
?>

<?php

function similarity_distance($matrix, $person1, $person2) {
    if (!is_array($matrix[$person1]) || !is_array($matrix[$person2])) {
        return 0;
    }

    $similar = array();
    foreach ($matrix[$person1] as $key => $value) {
        if (array_key_exists($key, $matrix[$person2])) {
            $similar[$key] = 1;
        }
    }
    if (count($similar) == 0) {
        return 0;
    }

    $sum = 0;
    foreach ($matrix[$person1] as $key => $value) {
        if (array_key_exists($key, $matrix[$person2])) {
            $sum += pow($value - $matrix[$person2][$key], 2);
        }
    }
    return 1 / (1 + sqrt($sum)); // Changed to avoid potential division by zero
}

function getRecommantion($matrix, $person) {
    $total = array();
    $simsum = array();
    $ranks = array();
    $different_data = array();

    foreach ($matrix as $otherperson => $value) {
        if ($otherperson != $person) {
            $sim = similarity_distance($matrix, $person, $otherperson);

       
            if ($sim <= 0) {
                // Collect different data
                $different_data[$person] = $matrix[$person];
                $different_data[$otherperson] = $matrix[$otherperson];
                continue;
            }

            foreach ($matrix[$otherperson] as $key => $value) {
                if (!array_key_exists($key, $matrix[$person]) || $matrix[$person][$key] == 0) {
                    if (!array_key_exists($key, $total)) {
                        $total[$key] = 0;
                    }
                    $total[$key] += $matrix[$otherperson][$key] * $sim;

                    if (!array_key_exists($key, $simsum)) {
                        $simsum[$key] = 0;
                    }
                    $simsum[$key] += $sim;
                }
            }
        }
    }



    foreach ($total as $key => $value) {
        if ($simsum[$key] != 0) {
            $ranks[$key] = $value / $simsum[$key];
        } else {
            $ranks[$key] = 0; // Handle the case where $simsum[$key] is zero
        }
    }

    array_multisort($ranks, SORT_DESC);


    return $ranks;
}
?>
