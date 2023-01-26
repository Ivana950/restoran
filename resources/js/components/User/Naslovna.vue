<template>
    <div class="content">
        <div class="banner d-flex align-items-center justify-content-center">
            <div class="pt-16 text-center">
                <h1 class="pt-8 pb-3 display-2">
                    Dobrodošli u restoran Toscana!
                </h1>
                <v-btn
                    @click="napraviRezervaciju()"
                    rounded
                    color="teal darken-1"
                    dark
                    >Napravi Rezervaciju</v-btn
                >
            </div>
        </div>
        <div class="container my-16">
            <v-row>
                <v-col>
                    <h2>O NAMA</h2>
                    <p>
                        Restoran - Pizzeria Toscana predstavlja spoj kreativnog
                        i brzog pripremanja hrane.
                    </p>
                    <p>
                        U ponudi imamo brojne vrste pizza, ukusne mesne i riblje
                        specijalitete, brojne vrste risotta i salata, uvijek
                        svježe pripremljene za Vas. Sve je to samo uvod za
                        izvrsne kolače, kupove i sladolede.
                    </p>
                    <p>
                        U našem restoranu Vas očekuje kvalitetna hrana, brza i
                        ljubazna usluga. Dođite i uživajte u dobro poznatom
                        okusu!
                    </p>
                    <v-btn color="teal darken-1" dark>SAZNAJTE VIŠE</v-btn>
                </v-col>
                <v-col class="d-flex align-items-center justify-content-center">
                    <img
                        src="https://images.pexels.com/photos/3887985/pexels-photo-3887985.jpeg?auto=compress&cs=tinysrgb&w=600"
                        width="400"
                        height="400"
                /></v-col>
            </v-row>
        </div>
        <div class="grey lighten-2">
            <div class="container">
                <v-row class="text-center my-16">
                    <v-col>
                        <img src="images/slike/img9.png" class="mb-3" />
                        <h2>SVJEŽA JELA</h2>
                        <p>
                            Inovativna kuhinja, orginalnost serviranja pokoriće
                            vašu maštu i upotpuniti harmoniju ljepote i ukusa.
                            Uvijek svježe namirnice uz jedinstvene ukuse
                            kuhinje, garant su vrhunskog gastronomskog užitka.
                        </p>
                    </v-col>
                    <v-col>
                        <img src="images/slike/img10.png" class="mb-3" />
                        <h2>RAZNOLIKI MENI</h2>
                        <p>
                            Ovdje će svako pronaći svoj omiljeni zalogaj uz
                            bogat izbor jela od mesa i ribe, topla i hladna
                            predjela, rižota, paste, salate, pizza i deserte uz
                            veliki izbor pića, a za naše najmlađe poseban
                            dječiji meni.
                        </p>
                    </v-col>

                    <v-col>
                        <img src="images/slike/img11.png" class="mb-3" />
                        <h2>KVALITETNA USLUGA</h2>
                        <p>
                            Privlačan dizajn objekta, uz raznolik izbor hrane i
                            pića čine nas prepoznatljivim, dok dobra usluga
                            nikoga ne ostavlja ravnodušnim. Higijena na visokom
                            nivou, profesionalnost i ljubaznost je ono što naše
                            osoblje nudi.
                        </p>
                    </v-col>
                </v-row>
            </div>
        </div>
        <div class="container">
            <v-row class="py-6">
                <v-col
                    v-for="image in images"
                    :key="image.id"
                    class="d-flex child-flex"
                    cols="4"
                >
                    <v-img
                        :src="`${image.path}`"
                        :lazy-src="`${image.path}`"
                        aspect-ratio="1"
                        class="grey lighten-2"
                    >
                        <template v-slot:placeholder>
                            <v-row
                                class="fill-height ma-0"
                                align="center"
                                justify="center"
                            >
                                <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                ></v-progress-circular>
                            </v-row>
                        </template>
                    </v-img>
                </v-col>
            </v-row>
        </div>

        <my-footer></my-footer>
    </div>
</template>
<script>
export default {
    created() {},
    data: () => ({
        images: [
            {
                name: "slika-1",
                path: "images/slike/1.jpg",
            },
            {
                name: "slika-2",
                path: "images/slike/2.jpg",
            },
            {
                name: "slika-3",
                path: "images/slike/3.webp",
            },
            {
                name: "slika-4",
                path: "images/slike/4.jpeg",
            },
            {
                name: "slika-5",
                path: "images/slike/5.jpeg",
            },
            {
                name: "slika-6",
                path: "images/slike/6.jpeg",
            },
        ],
    }),
    methods: {
        napraviRezervaciju() {
            window.location = "http://127.0.0.1:8000/user/rezervacija";
        },
    },
};
</script>
<style scoped>
h2 {
    font-weight: 500;
}
.content {
    background-color: var(--bs-gray-100);
}
.banner {
    height: 400px;
    background-image: url("https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
    background-size: cover;
}
.container {
    width: 70%;
    color: var(--bs-body-color);
}
img {
    border-radius: 10px;
}
</style>
