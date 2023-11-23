<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/2 px-4">
            <img src="/public/assets/<?= $ressource->image ?>" alt="Image du livre" class="mb-4 rounded-lg object-cover m-auto h-[70vh]">
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-1/2 px-4 mt-6 md:mt-0">
            <div class="bg-white shadow-lg rounded-lg px-6 py-4">
                <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= $ressource->titre ?></h1>
                <p class="text-gray-600 mb-2">Année de publication: <span class="font-semibold"><?= $ressource->anneesortie ?></span></p>
                <p class="text-gray-600 mb-2">Langue : <span class="font-semibold"><?= $ressource->langue ?></span></p>
                <p class="text-gray-600 mb-2">ISBN : <span class="font-semibold"><?= $ressource->isbn ?></span></p>
                <p class="text-gray-600 mb-2">Auteur : <span class="font-semibold">
                        <?php
                        foreach ($auteurs as $auteur) {
                            echo $auteur->nomAuteur . " " . $auteur->prenomAuteur . " ";
                        }
                        ?>
                    </span></p>
                <p class="text-gray-600 mb-2">Description: <span class="font-semibold"><?= $ressource->description ?></p>

                <!-- Bouton pour emprunter un exemplaire -->
                <?php if ($exemplaire && isset($_SESSION["LOGIN"])) { ?>
                    <form id="exemplaire" method="post" class="text-center pt-5 pb-3" action="/catalogue/emprunter">
                        <input type="hidden" name="idRessource" value="<?= $ressource->idressource ?>">
                        <input type="hidden" name="idExemplaire" value="<?= $exemplaire->idexemplaire ?>">
                        <button type="submit" class="bg-indigo-600 text-white hover:bg-indigo-900 font-bold py-3 px-6 rounded-full">
                            Emprunter
                        </button>
                    </form>
                <?php } elseif (!$exemplaire && isset($_SESSION["LOGIN"])) {
                ?>
                    <p class="text-red-500 text-xs italic">Aucun exemplaire disponible</p>
                <?php
                } ?>
            </div>

            <?php
            // Formulaire pour laisser un commentaire
            if (isset($_SESSION["LOGIN"])) {
            ?>
                <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Laisser un commentaire</h2>
                    <form method="post" action="/commenter/<?= $ressource->idressource ?>">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="note">
                                Note
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= isset($errors["note"]) ? "border-red-500" : "" ?>" id="note" name="note" type="number" min="0" max="5" value="<?= isset($_POST["note"]) ? $_POST["note"] : "" ?>">
                            <?php if (isset($errors["note"])) { ?>
                                <p class="text-red-500 text-xs italic"><?= $errors["note"] ?></p>
                            <?php } ?>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="commentaire">
                                Commentaire
                            </label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= isset($errors["commentaire"]) ? "border-red-500" : "" ?>" id="commentaire" name="commentaire" rows="5"><?= isset($_POST["commentaire"]) ? $_POST["commentaire"] : "" ?></textarea>
                            <?php if (isset($errors["commentaire"])) { ?>
                                <p class="text-red-500 text-xs italic"><?= $errors["commentaire"] ?></p>
                        <?php }
                        } ?>
                        </div>

                        <?php
                        if (isset($_SESSION["LOGIN"])) {
                        ?>
                            <!-- Bouton d'envoi du commentaire -->
                            <div class="flex items-center justify-between mt-6">
                                <button class="bg-indigo-600 hover:bg-indigo-900 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline" type="submit">
                                    Envoyer
                                </button>
                            </div>
                        <?php
                        } ?>
                    </form>
                </div>

                <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Commentaire(s)</h2>
                </div>
                <?php
                if ($commentaires) {
                    foreach ($commentaires as $commentaire) {
                ?>
                        <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-6">
                            <p class="text-gray-600 mb-2">Auteur : <span class="font-semibold"><?= htmlspecialchars($commentaire->prenomemprunteur . " " . $commentaire->nomemprunteur) ?></span></p>
                            <p class="text-gray-600 mb-2">Date : <span class="font-semibold"><?= date_format(date_create($commentaire->dateCreation), "d/m/Y") ?></span></p>
                            <p class="text-gray-600 mb-2">Note : <span class="font-semibold"><?= $commentaire->note ?></span></p>
                            <p class="text-gray-600 mb-2">Commentaire : <span class="font-semibold"><?= htmlspecialchars($commentaire->contenu) ?></span></p>
                        </div>
                <?php
                    }
                }
                ?>
        </div>
    </div>
</div>

<script>
    document.querySelector("#exemplaire").addEventListener("submit", async (e) => {
        e.preventDefault()
        const result = await Swal.fire({
            title: 'Confirmer l\'emprunt ?',
            text: "Souhaitez-vous emprunter cette ressource ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non'
        })
        if (result.isConfirmed) {
            e.target.submit()
        }
    });
</script>