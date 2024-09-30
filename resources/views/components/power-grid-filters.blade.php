<div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('updatePurokOptions', function(data) {
                let purokSelect = document.querySelector('[wire\\:model\\.defer="filters.select.purok"]');
                purokSelect.innerHTML = '<option value="">Select Purok</option>';
                data.puroks.forEach(function(purok) {
                    let option = document.createElement('option');
                    option.value = purok.id;
                    option.textContent = purok.name;
                    purokSelect.appendChild(option);
                });
            });
        });
    </script>
</div>