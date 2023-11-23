<div class="container mx-auto py-8 min-h-[calc(100vh-136px)]">
    <div class="flex flex-wrap">
        <!-- Colonne de gauche -->
        <div class="w-full md:w-1/3 px-4">
            <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg px-6 py-4">
                <div class="flex items-center justify-center mb-4">
                    <img src="<?= \utils\Gravatar::get_gravatar($user->emailemprunteur) ?>" alt="Photo de profil" class="rounded-full h-32 w-32">
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">👋 <?= $user->prenomemprunteur ?></h1>
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Informations personnelles</h2>
                    <p class="text-gray-600 mb-2"><span class="font-semibold">Email :</span> <?= $user->emailemprunteur ?></p>
                    <p class="text-gray-600 mb-2"><span class="font-semibold">Nom :</span> <?= $user->nomemprunteur ?>
                    </p>
                    <p class="text-gray-600 mb-2"><span class="font-semibold">Prénom :</span> <?= $user->prenomemprunteur ?></p>
                </div>

                <div class="p-5 text-center">
                    <a class="bg-blue-600 text-white hover:bg-blue-900 font-bold py-3 px-6 rounded-full" href="/user/modifyUser">
                        Modifier mes informations
                    </a>
                    <br>
                    <br>
                    <br>
                    <a class="bg-green-600 text-white hover:bg-green-900 font-bold py-3 px-6 rounded-full" href="/user/dlUser">
                        Télécharger mes informations
                    </a>
                    <br>
                    <br>
                    <br>
                    <a class="bg-red-600 text-white hover:bg-red-900 font-bold py-3 px-6 rounded-full" href="/logout">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="w-full md:w-2/3 px-4 mt-6 md:mt-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes emprunts</h1>

            <?php if (!$emprunts) { ?>
                <!-- Message si aucun emprunt -->
                <div class="bg-white shadow-lg rounded-lg px-6 py-4 mt-5">
                    <p class="text-gray-600 mb-2">Vous n'avez aucun emprunt en cours.</p>
                </div>
            <?php } else { ?>
                <!-- Tableau des emprunts -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-5">

                    <!-- Liste des emprunts -->
                    <?php foreach ($emprunts as $emprunt) { ?>
                        <div class="bg-white shadow-lg rounded-lg px-6 py-4">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2"><?= $emprunt->titre ?></h2>
                            <p class="text-gray-600 mb-2">Type : <span class="font-semibold"><?= $emprunt->libellecategorie ?></span></p>
                            <p class="text-gray-600 mb-2">
                                Date d'emprunt :
                                <span class="font-semibold"><?= date_format(date_create($emprunt->datedebutemprunt), "d/m/Y") ?></span>
                            </p>
                            <?php
                            // Calcul le nombre de jours avant la date de retour
                            $jours = date_diff(date_create($emprunt->dateretour), date_create(date("Y-m-d")))->format("%a");
                            ?>
                            <p class="text-gray-600 mb-2">
                                Date de retour prévue :
                                <span class="font-semibold"><?= date_format(date_create($emprunt->dateretour), "d/m/Y") . " ($jours)" ?></span>
                            </p>
                            <?php
                            // Si la date de retour est dépassée, on calcule le coût de la pénalité
                            if (date_create($emprunt->dateretour) < date_create(date("Y-m-d"))) {
                                $cout = (date_diff(date_create($emprunt->dateretour), date_create(date("Y-m-d")))->format("%a"));
                            ?>
                                <p class="text-white bg-red-600 rounded-full px-4 py-2">
                                    <!-- on affiche dans le coin de la carte un petit texte blanc sur fond rouge -->
                                    En retard ! Vous avez <?= $cout ?>€ de pénalité de retard !
                                </p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>