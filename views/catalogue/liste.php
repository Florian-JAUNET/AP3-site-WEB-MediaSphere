<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <h2 class="text-3xl font-bold text-gray-800 mb-4"><?= $titre ?></h2>

    <!-- Ajoute une liste déroulante pour séléctionner les ressources par type -->
    <form action="/catalogue" method="get" onchange="changementListe()">
        <select name="type" id="type" class="w-1/4 mb-4 border border-gray-300 rounded-md shadow-sm py-2 px-3 text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="Tous">Tous les types</option>
            <?php foreach ($categories as $categorie) { ?>
                <option value="<?= $categorie->idcategorie ?>" <?= (isset($_GET['type']) && $_GET['type'] == $categorie->idcategorie) ? 'selected' : '' ?>><?= $categorie->libellecategorie ?></option>
            <?php } ?>
        </select>
        <!-- <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Rechercher</button> -->
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 container mx-auto">
        <?php foreach ($catalogue as $ressources) { ?>
            <a href="/catalogue/detail/<?= $ressources->idressource ?>" class="bg-white rounded-lg shadow-lg">
                <img loading="lazy" src="/public/assets/<?= $ressources->image ?>" alt="<?= htmlspecialchars($ressources->titre) ?>" class="w-full h-64 object-cover object-center rounded-t-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 truncate"><?= $ressources->titre ?></h3>
                    <div class="w-fit flex justify-center items-center font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                        <div class="text-xs font-normal leading-none max-w-full flex-initial">
                            <?= $ressources->libellecategorie ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
    </div>
</div>

<script>
    function changementListe() {
        // Récupère la valeur de la liste
        let selectedValue = document.querySelector('#type').value;
        // Quand la liste est changée, on submit le formulaire
        document.querySelector('form').submit();
        // On remet la liste à la valeur actuelle
        document.querySelector('#type').value = selectedValue;
    }
</script>