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
<tr>
  <td>
    <?php echo htmlspecialchars($course); ?>
  </td>
  <td>
    <?php echo htmlspecialchars($term); ?>
  </td>
  <td>
    <?php echo htmlspecialchars($year); ?>
  </td>
  <td>
    <?php echo htmlspecialchars($credits); ?>
  </td>
  <td class="min">
    <?php echo htmlspecialchars($grade); ?>
  </td>
</tr>
