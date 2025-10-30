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

$page_title = "Yoko's Kitchen";

$nav_cooking_class = "active_page";

const BOOLEAN_CODINGS = array(
  False => 0,
  True => 1
);

// form data
$form_values = array(
  "course-vegetarian" => NULL,
  "course-sauces" => NULL,
  "email" => NULL
);

// Store sticky values for form inputs
$sticky_values = array(
  "course-vegetarian" => "",
  "course-sauces" => "",
  "email" => ""
);

// show/hide form corrective feedback
$show_feedback = array(
  "courses" => False,
  "email" => False
);

// initial page state (hide confirmation message)
$show_confirmation_message = False;

// Did the user submit the form? (submit button parameter exists)
if (isset($_POST["request"])) {

  // Assume the form is valid
  $form_valid = True;

  // Get HTTP request user data
  $form_values["course-vegetarian"] = isset($_POST["japanese-vegetarian"]);
  $form_values["course-sauces"] = isset($_POST["sauces-masterclass"]);
  $form_values["email"] = trim($_POST["email"] ?? "");

  // Was at least one course check box, checked?
  if (
    !$form_values["course-vegetarian"] &&
    !$form_values["course-sauces"]
  ) {
    // no course selected, form is not valid
    $form_valid = False;

    // show courses feedback message by removing hidden class
    $show_feedback["courses"] = True;
  }

  // Email is required; is the email format correct (does not validate if email exists)
  if (!filter_var($form_values["email"], FILTER_VALIDATE_EMAIL)) {
    // no email provided, it's required!
    // form is not valid
    $form_valid = False;

    // show email feedback message by removing hidden class
    $show_feedback["email"] = True;
  }

  // If the form is valid, show confirmation message
  if ($form_valid) {
    // form is valid, insert record into database
    $result = exec_sql_query(
      $db,
      "INSERT INTO course_requests (email, course_vegetarian, course_sauces) VALUES (:email, :course_vegetarian, :course_sauces);",
      array(
        ":email" => $form_values["email"],
        ":course_vegetarian" => BOOLEAN_CODINGS[$form_values["course-vegetarian"]],
        ":course_sauces" => BOOLEAN_CODINGS[$form_values["course-sauces"]]
      )
    );

    // form is valid, show confirmation message
    $show_confirmation_message = True;
  } else {
    // form was not valid, set sticky values
    $sticky_values["course-vegetarian"] = ($form_values["course-vegetarian"] ? "checked" : "");
    $sticky_values["course-sauces"] = ($form_values["course-sauces"] ? "checked" : "");
    $sticky_values["email"] = $form_values["email"];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "includes/meta.php" ?>

<body>
  <?php include "includes/header.php" ?>

  <main class="courses">

    <h2><?php echo htmlspecialchars($page_title); ?></h2>

    <p>Welcome to Yoko's Kitchen!</p>

    <h2>Cooking Classes</h2>

    <section>
      <div class="course-tile">
        <figure>
          <img src="/images/bok-choi.jpg" alt="Bok Choi" />
          <figcaption>Bok Choi</figcaption>
        </figure>
        <div>
          <div>
            <h3>Japanese Vegetarian</h3>
            <h4>Five week course in London</h4>
          </div>
          <p>A five week introduction to traditional Japanese vegetarian meals, teaching you a selection of rice and noodle dishes.</p>
        </div>
      </div>

      <div class="course-tile">
        <figure>
          <img src="/images/teriyaki.jpg" alt="Teriyaki sauce" />
          <figcaption>Teriyaki Sauce</figcaption>
        </figure>
        <div>
          <div>
            <h3>Sauces Masterclass</h3>
            <h4>One day workshop</h4>
          </div>
          <p>An intensive one-day course looking at how to create the most delicious sauces for use in a range of Japanese cookery.</p>
        </div>
      </div>
    </section>

    <section id="request">
      <h2>Request Course Information</h2>

      <?php if ($show_confirmation_message) { ?>

        <p>Thank you for your interest in our cooking classes!</p>
        <p>We will send information about these courses to you shortly.</p>

      <?php } else { ?>

        <p>Interesting in taking one of our cooking classes? Let us know which classes and we'll send you some information!</p>

        <form id="request-form" action="/cooking-classes#request" method="post" novalidate>

          <?php if ($show_feedback["courses"]) { ?>
            <div id="feedback-classes" class="feedback">Select one or more classes.</div>
          <?php } ?>

          <div class="form-label">
            <input type="checkbox" name="japanese-vegetarian" id="request-vegetarian" <?php echo $sticky_values["course-vegetarian"]; ?>>
            <label for="request-vegetarian">Japanese Vegetarian</label>
          </div>
          <div class="form-label">
            <input type="checkbox" name="sauces-masterclass" id="request-sauces" <?php echo $sticky_values["course-sauces"]; ?>>
            <label for="request-sauces">Sauces Masterclass</label>
          </div>

          <?php if ($show_feedback["email"]) { ?>
            <div id="feedback-email" class="feedback">Enter your email address.</div>
          <?php } ?>

          <div class="form-label">
            <label for="request-email">Email:</label>
            <input type="email" name="email" id="request-email" value="<?php echo htmlspecialchars($sticky_values["email"]); ?>">
          </div>

          <div class="align-right">
            <button id="request-submit" type="submit" name="request">
              Request Information
            </button>
          </div>
        </form>

      <?php } ?>
    </section>

    <cite>&copy; 2011 Yoko's Kitchen (<a href="http://www.htmlandcssbook.com/code-samples/chapter-17/example-with-links.html">Source</a>)</cite>
  </main>

  <?php include "includes/footer.php" ?>
</body>

</html>
