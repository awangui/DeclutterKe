<form action= "" method="POST">
       

<label for="fname">First Name:</label>
<input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($fname); ?>" required>

<label for="sname">Surname:</label>
<input type="text" id="sname" name="sname" value="<?php echo htmlspecialchars($sname); ?>" required>

<label for="email">Email address:</label>
<input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

<!-- Additional fields -->
<label for="phone">Phone:</label>
<input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone);  ?>"placeholder="include country code e.g 254700111222" required>


<label for="city">City:</label>
<input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>
<?php if ($message) : ?>
    <div class="alert <?php echo $messageClass; ?>"  style="text-align:center">
        <?php echo $message; ?>
    </div>
<?php endif; ?>
<button type="submit" name="submit">Save</button>
        </form>