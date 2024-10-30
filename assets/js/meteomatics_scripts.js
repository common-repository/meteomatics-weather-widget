document.addEventListener('DOMContentLoaded', function(){
  let embeddedElement = document.getElementById('meteomatics-widget');
  let previewButton = document.getElementById('meteomatics-preview');
  let error = '';
  const validColors = ["primary", "black", "white", "light-gray"];

  if (previewButton) {
    previewButton.addEventListener('click', function (event) {
      event.preventDefault();

      let errorMesssage = document.querySelector('.meteomatics-preview-errors');

      let meteomatics_latitude = document.getElementById('meteomatics_latitude').value;
      let meteomatics_longitude = document.getElementById('meteomatics_longitude').value;
      let meteomatics_location = document.getElementById('meteomatics_location').value;
      let meteomatics_color_select = document.getElementById('meteomatics_color_select').value;
      let meteomatics_variant_select = document.getElementById('meteomatics_variant_select').value;
      let meteomatics_units_select = document.getElementById('meteomatics_units_select').value;

      if (meteomatics_latitude < -90 || meteomatics_latitude > 90) {
        console.error("Invalid value for latitude");
        if (!error) error = 'Geo coordinates are missing or wrong.\n Please enter your coordinates above.';
      } else if (meteomatics_longitude < -180 || meteomatics_longitude > 180) {
        console.error("Invalid value for longitude");
        if (!error) error = 'Geo coordinates are missing or wrong.\n Please enter your coordinates above.';
      } else {
        error = '';
      }

      if (!validColors.includes(meteomatics_color_select)) {
        console.error(
          `Invalid color value - ${meteomatics_color_select}. "${php_vars.DEFAULT_COLOR}" value set by default`
        );
        meteomatics_color_select = php_vars.DEFAULT_COLOR;
      }

      if (
        meteomatics_units_select !== "celsius" &&
        meteomatics_units_select !== "fahrenheit"
      ) {
        console.error(
          `Invalid measurementUnits value - ${meteomatics_units_select}. "${php_vars.DEFAULT_UNITS}" value set by default`
        );
        meteomatics_units_select = php_vars.DEFAULT_UNITS;
      }

      if (!title) {
        console.warn("Invalid title value");
      }

      if (meteomatics_variant_select !== "vertical" && meteomatics_variant_select !== "horizontal") {
        console.error(
          `Invalid variant value - ${meteomatics_variant_select}. "${php_vars.DEFAULT_VARIANT}" set by default`
        );
        meteomatics_variant_select = php_vars.DEFAULT_VARIANT;
      }

      if (error) {
        errorMesssage.style.display = 'block';
        errorMesssage.innerText = error;
      } else {
        errorMesssage.innerText = '';
      }

      if (embeddedElement && !error) {
        if (meteomatics_latitude) {
          embeddedElement.setAttribute('data-meteomatics-weather-widget-latitude', meteomatics_latitude);
        }
        if (meteomatics_longitude) {
          embeddedElement.setAttribute('data-meteomatics-weather-widget-longitude', meteomatics_longitude);
        }
        if (meteomatics_location) {
          embeddedElement.setAttribute('data-meteomatics-weather-widget-title', meteomatics_location);
        }
        if (meteomatics_color_select) {
          embeddedElement.setAttribute('data-meteomatics-weather-widget-color', meteomatics_color_select);
        }
        if (meteomatics_variant_select) {
          embeddedElement.setAttribute('data-meteomatics-weather-widget', meteomatics_variant_select);
        }
        if (meteomatics_units_select) {
          embeddedElement.setAttribute('data-meteomatics-weather-widget-measurement-unit-temperature', meteomatics_units_select);
        }
      }

      if (!error && (typeof window.MeteomaticsWeatherWidget !== 'undefined')) window.MeteomaticsWeatherWidget.reload();
    });
  }


  // Copy shortcode to clipboard
  let copyButtons = document.querySelectorAll('.meteomatics-widget-shortcode, .meteomatics-widget-code');
  copyButtons.forEach(button => {
    button.addEventListener('click', function (event) {
      event.preventDefault();
      this.classList.add('copied');

      let shortcode = button.textContent.trim();

      navigator.clipboard.writeText(shortcode)
        .catch(error => {
          console.error('Could not copy text: ', error);
        });
    });
  });
});