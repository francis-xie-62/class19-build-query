<!-- Note: You may not copy the instructor's code/design and submit it  -->
<!--       as your own.                                                 -->
<!--                                                                    -->
<!-- We studied textual catalog design patterns in class, there are     -->
<!-- many design alternatives for for presenting textual information.   -->
<!-- You may use this design for inspiration. However, you must design  -->
<!-- your own.                                                          -->
<!--                                                                    -->
<!-- Remember, design is a learning objective of this class. Your your  -->
<!-- future employers will expect you to  be able to design on your own -->
<!-- without copying someone else's work. Use this experience as        -->
<!-- practice.                                                          -->
<li class="tile">
  <div class="tile-header">
    <h3><?php echo htmlspecialchars($name); ?></h3>

    <div class="tile-rating"><?php echo htmlspecialchars($rating); ?></div>
  </div>
  <p class="tile-review"><?php echo ($comment ? htmlspecialchars($comment) : ""); ?> </p>
</li>
