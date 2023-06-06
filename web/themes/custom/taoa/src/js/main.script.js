import { Toast, Tooltip } from './_bootstrap';

(function ($) {

	// * Tooltip initialization, remove it if not necessary
	document
		.querySelectorAll('[data-toggle="tooltip"]')
		.forEach((tooltipElement) => new Tooltip(tooltipElement));

	// * Toast initialization, remove it if not necessary
	document
		.querySelectorAll('.toast')
		.forEach((toastElement) => new Toast(toastElement));

  Drupal.behaviors.addWorkSampleAndWorkTypesInteraction = {
    attach: function (context, settings) {
      once('work-sample-work-type-init', '.view-work-types .taxonomy-term.work-type', document).forEach(t => {
        t.addEventListener('click', e => {
          const term = t.getAttribute('data-taxonomy');
          const select = document.querySelector('.view-work-samples select[data-drupal-selector="edit-work-type"]');
          select.value = term;
          const button = document.querySelector('.view-work-samples .form-submit');
          button.dispatchEvent(new MouseEvent('click'));
        });
      });
    },
  };

  Drupal.behaviors.addWorkSampleAndWorkTypesInteractionController = {
    attach: function (context, settings) {
      once('work-sample-work-type-controller-init', '.view-work-types .taxonomy-term.work-type', document).forEach(t => {
        t.addEventListener('click', e => {
          const term = t.getAttribute('data-taxonomy');
          $.get(`/api/work-samples/${term}`, data => {
            t
              .closest('.view-work-types')
              .querySelector('.samples-wrapper')
              .innerHTML = data;
          });
        });
      });
    },
  };

  Drupal.behaviors.addWorkSampleAndWorkTypesInteractionREST = {
    attach: function (context, settings) {
      return;
      once('work-sample-work-type-rest-init', '.view-work-types .taxonomy-term.work-type', document).forEach(t => {
        t.addEventListener('click', e => {
          const term = t.getAttribute('data-taxonomy');
          const wrapper = t
            .closest('.view-work-types')
            .querySelector('.samples-wrapper-2');
          wrapper.innerHTML = '';

          $.get(`/api/2/work-samples/${term}`, data => {
            data.forEach(sample => {
              wrapper.innerHTML += sample.rendered_entity;
            });
          });
        });
      });
    },
  };

})(jQuery);
