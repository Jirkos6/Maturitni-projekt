document.addEventListener('DOMContentLoaded', event => {
  const achievementSearch = document.getElementById('achievement-search');
  if (achievementSearch) {
    achievementSearch.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase();
      document.querySelectorAll('.achievement-item').forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase();
        item.style.display = name.includes(searchTerm) ? '' : 'none';
      });
    });
  }

  function editAchievement(id, name, description, image) {
    const form = document.getElementById('editAchievementForm');
    const nameInput = document.getElementById('Lpname');
    const descriptionInput = document.getElementById('Lpdescription');
    const imagePreview = document.getElementById('Lpimage');

    if (!form || !nameInput || !descriptionInput || !imagePreview) {
      return;
    }

    form.action = `/achievement/${id}`;
    nameInput.value = name;
    descriptionInput.value = description || '';
    imagePreview.src = image;

    const modal = new bootstrap.Modal(document.getElementById('editAchievementModal'));
    modal.show();
  }

  window.editAchievement = editAchievement;
});
