<?php
// OrderFlow — calcul de la remise par palier (S1-TP1, règles RG1 à RG6).

const PALIERS_REMISE = [   // seuil en centimes => taux de remise (%)
    200000 => 15,
    50000  => 10,
    10000  => 5,
];

function calculerRemise(mixed $montantCentimes): int
{
    if (!is_int($montantCentimes)) {
        throw new InvalidArgumentException('Le montant doit être un entier en centimes'); // RG6
    }
    if ($montantCentimes < 0) {
        throw new InvalidArgumentException('Le montant ne peut pas être négatif');      // RG5
    }
    return intdiv($montantCentimes * tauxDeRemise($montantCentimes), 100);              // RG3 : arrondi inférieur
}

function tauxDeRemise(int $montantCentimes): int
{
    foreach (PALIERS_REMISE as $seuil => $taux) {
        if ($montantCentimes >= $seuil) {
            return $taux;
        }
    }
    return 0;
}
