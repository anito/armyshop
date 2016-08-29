<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h1 class="display-3">Outdoor</h1>
    <div class="right"><a class="btn btn-primary btn-lg" href="#" role="button">Erfahren Sie mehr »</a></div>
  </div>
</div>
<div class="pricing pricing--norbu">
  <div class="pricing__item">
    <h3 class="pricing__title">Rucksack 1</h3>
    <p class="pricing__sentence">Für optimalen Komfort</p>
    <div class="pricing__price"><span class="pricing__currency">$</span>19<span class="pricing__period">/ month</span></div>
    <ul class="pricing__feature-list">
      <li class="pricing__feature">Maximales Fassungsvermögen</li>
      <li class="pricing__feature">Wassergeschützt</li>
      <li class="pricing__feature">Ultra flexibel</li>
    </ul>
    <button class="pricing__action">Choose plan</button>
  </div>
  <div class="pricing__item pricing__item--featured">
    <h3 class="pricing__title">Rucksack 2</h3>
    <p class="pricing__sentence">Für optimalen Komfort</p>
    <div class="pricing__price"><span class="pricing__currency">$</span>19<span class="pricing__period">/ month</span></div>
    <ul class="pricing__feature-list">
      <li class="pricing__feature">Maximales Fassungsvermögen</li>
      <li class="pricing__feature">Wassergeschützt</li>
      <li class="pricing__feature">Ultra flexibel</li>
    </ul>
    <button class="pricing__action">Choose plan</button>
  </div>
  <div class="pricing__item">
    <h3 class="pricing__title">Rucksack 3</h3>
    <p class="pricing__sentence">Für optimalen Komfort</p>
    <div class="pricing__price"><span class="pricing__currency">$</span>19<span class="pricing__period">/ month</span></div>
    <ul class="pricing__feature-list">
      <li class="pricing__feature">Maximales Fassungsvermögen</li>
      <li class="pricing__feature">Wassergeschützt</li>
      <li class="pricing__feature">Ultra flexibel</li>
    </ul>
    <button class="pricing__action">Choose plan</button>
  </div>
</div>
<?php
  echo $this->Html->scriptStart();
    ?>
    var base_url = '<?php echo $this->Html->url('/outdoor'); ?>';
    <?php
  echo $this->Html->scriptEnd();

?>

