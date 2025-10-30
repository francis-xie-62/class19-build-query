<?php
/* Note: No credit is provided for submitting design and/or code that is     */
/*       taken from course-provided examples.                                */
/*                                                                           */
/* Do not copy this code into your project submission and then change it.    */
/*                                                                           */
/* Write your own code from scratch. Use this example as a REFERENCE only.   */
/*                                                                           */
/* You may not copy this code, change a few names/variables, and then claim  */
/* it as your own.                                                           */
/*                                                                           */
/* Examples are provided to help you learn. Copying the example and then     */
/* changing it a bit, does not help you learn the learning objectives of     */
/* this assignment. You need to write your own code from scratch to help you */
/* learn.                                                                    */

$page_title = "Flowershop";

$nav_flowershop_class = "active_page";

const FLOWERS = array(
  1 => "roses",
  2 => "daises",
  3 => "gardenias"
);

// initial page state (hide confirmation message)
$show_confirmation_message = false;

// CSS classes for form feedback messages
$show_feedback = array(
  "name" => False,
  "phone" => False,
  "bouquet" => False
);

// default form values
$form_values = array(
  "name" => NULL,
  "phone" => NULL,
  "bouquet" => NULL
);

// default sticky values for form inputs
$sticky_values = array(
  "name" => "",
  "phone" => "",
  "roses" => "",
  "daisies" => "",
  "gardenias" => ""
);

// default sticky values for form inputs
if (isset($_POST["request-sample"])) {

  // Assume the form is valid
  $form_valid = true;

  // Get HTTP request user data
  $form_values["name"] = trim($_POST["name"]);
  $form_values["name"] = $form_values["name"] == "" ? NULL : $form_values["name"];

  $form_values["phone"] = trim($_POST["phone"]);
  $form_values["phone"] = $form_values["phone"] == "" ? NULL : $form_values["phone"];

  $form_values["bouquet"] = isset($_POST["bouquet"]) ? (int)$_POST["bouquet"] : NULL;

  // Name is required; is the name value empty?
  // Note: Does not validate name format.
  //       For project 2 only validate: required or not required.
  if ($form_values["name"] == NULL) {
    // no name provided, it's required!
    // form is not valid
    $form_valid = false;

    // show name feedback message by removing hidden class
    $show_feedback["name"] = True;
  }

  // Phone is required; is the phone value empty?
  // Note: Does not validate phone format.
  //       For project 2 only validate: required or not required.
  if ($form_values["phone"] == NULL) {
    // no phone provided, it's required!
    // form is not valid
    $form_valid = false;

    // show phone feedback message by removing hidden class
    $show_feedback["phone"] = True;
  }

  // Bouquet is required; check bouquet type -- only 3 types are valid
  if (!in_array($form_values["bouquet"], array_keys(FLOWERS))) {
    // no bouquet provided, it's required!
    // form is not valid
    $form_valid = false;

    // show bouquet feedback message by removing hidden class
    $show_feedback["bouquet"] = True;
  }

  // If the form is valid, show confirmation message
  if ($form_valid) {
    // insert sample request record into database.
    $result = exec_sql_query(
      $db,
      "INSERT INTO flower_samples (business_name, phone, sample_type) VALUES (:business, :phone_no, :bouquet_type);",
      array(
        ":business" => $form_values["name"],
        ":phone_no" => $form_values["phone"],
        ":bouquet_type" => $form_values["bouquet"]
      )
    );

    // form is valid, show confirmation message
    $show_confirmation_message = true;
  } else {
    // form was not valid, set sticky values
    $sticky_values["name"] = $form_values["name"];
    $sticky_values["phone"] = $form_values["phone"];

    $sticky_values["roses"] = ($form_values["bouquet"] == 1 ? "checked" : "");
    $sticky_values["daisies"] = ($form_values["bouquet"] == 2 ? "checked" : "");
    $sticky_values["gardenias"] = ($form_values["bouquet"] == 3 ? "checked" : "");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "includes/meta.php" ?>

<body>
  <?php include "includes/header.php" ?>

  <main class="flowers">

    <!-- Note: You may not copy the instructor's code/design and submit it  -->
    <!--       as your own.                                                 -->
    <!--                                                                    -->
    <!-- Why may you not copy this code and modify it?                      -->
    <!-- Because modifying code and writing code from scratch are distinct  -->
    <!-- skills. What's important in the assignments is the _process you go -->
    <!-- through to figure out how all of these moving pieces connect       -->
    <!-- together to create server-side interactivity. It's much harder to  -->
    <!-- make these connections by taking already working code and          -->
    <!-- modifying it to fit your purposes.                                 -->

    <?php if (!$show_confirmation_message) { ?>

      <h2><?php echo $page_title; ?></h2>

      <p>Welcome to the 2300 Flower Shop! We are a wholesale supplier of flowers. We specialize in bulk sales of fresh cut-flowers.</p>

      <h2 id="request">Sample Request Form</h2>

      <p>Our premium quality flowers are the best in Ithaca. See the quality yourself! Use the form below to request a <em>free</em> sample bouquet of roses, daisies, or gardenias.</p>

      <form method="post" action="/flowershop#request" novalidate>

        <?php if ($show_feedback["name"]) { ?>
          <p class="feedback">Provide your business" name.</p>
        <?php } ?>

        <div class="label-input">
          <label for="name_field">Business Name:</label>
          <input id="name_field" type="text" name="name" value="<?php echo $sticky_values["name"]; ?>">
        </div>

        <?php if ($show_feedback["phone"]) { ?>
          <p class="feedback">Provide a contact phone number.</p>
        <?php } ?>

        <div class="label-input">
          <label for="phone_field">Contact Phone:</label>
          <input id="phone_field" type="tel" name="phone" value="<?php echo $sticky_values["phone"]; ?>">
        </div>

        <?php if ($show_feedback["bouquet"]) { ?>
          <p class="feedback">Select a sample bouquet.</p>
        <?php } ?>

        <div class="form-group label-input" role="group" aria-labelledby="bouquet_head">
          <div id="bouquet_head">
            Bouquet:
          </div>
          <div>
            <div>
              <input type="radio" id="roses_input" name="bouquet" value="1" <?php echo $sticky_values["roses"]; ?>>
              <label for="roses_input">Roses</label>
            </div>
            <div>
              <input type="radio" id="daisies_input" name="bouquet" value="2" <?php echo $sticky_values["daisies"]; ?>>
              <label for="daisies_input">Daisies</label>
            </div>
            <div>
              <input type="radio" id="gardenias_input" name="bouquet" value="3" <?php echo $sticky_values["gardenias"]; ?>>
              <label for="gardenias_input">Gardenias</label>
            </div>
          </div>
        </div>

        <div class="align-right">
          <button type="submit" name="request-sample">
            Request Sample
          </button>
        </div>
      </form>

    <?php } else { ?>

      <h2>Sample Request Confirmation</h2>

      <p>Thank you, <?php echo htmlspecialchars($form_values["name"]); ?>, for your request. We will contact you at <?php echo htmlspecialchars($form_values["phone"]); ?> to arrange a delivery date, time, and location for your sample <?php echo htmlspecialchars(FLOWERS[$form_values["bouquet"]]); ?> bouquet.</p>

      <p><a href="/flowershop">Request another sample</a>.</p>

    <?php } ?>

  </main>

  <?php include "includes/footer.php" ?>
</body>

</html>
