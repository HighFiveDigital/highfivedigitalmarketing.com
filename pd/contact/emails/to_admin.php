<email>
  <subject>New Contact: <?php pd('write')->str($data['name']); ?></subject>
  <message>

New contact for High Five:


Name: <?php pd('write')->str($data['name']); ?>

Email: <?php pd('write')->str($data['email']); ?>

Phone: <?php pd('write')->str($data['phone']); ?>

Message: <?php pd('write')->str($data['message']); ?>

  </message>
</email>