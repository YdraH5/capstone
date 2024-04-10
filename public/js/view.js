document.querySelectorAll('.view-report').forEach(button => {
  button.addEventListener('click', function() {
      const reportId = this.dataset.reportId;
      const modalId = `reportview${reportId}`;
      const modal = document.getElementById(modalId);
      modal.classList.remove('hidden');
  });
});

document.querySelectorAll('.closeview').forEach(closeButton => {
  closeButton.addEventListener('click', function () {
      const reportId = this.dataset.reportId;
      const modalId = `reportview${reportId}`;
      const modal = document.getElementById(modalId);
      modal.classList.add('hidden');
  });
});
