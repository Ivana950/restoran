<template>
    <div class="content">
        <div class="container pt-8 pb-16">
            <h1 class="text-center">Meni</h1>
            <v-divider class="orange darken-4" thickness="20px"></v-divider>
            <v-row>
                <v-col cols="4" v-for="m in meni" :key="m.id">
                    <v-card class="mx-auto" max-width="344">
                        <v-img :src="`${url}${m.slika}`" height="" />

                        <v-card-title> {{ m.naziv }} </v-card-title>

                        <v-card-subtitle>
                            {{ m.opis }}
                        </v-card-subtitle>

                        <v-card-actions>
                            <v-btn
                                color="orange darken-4 "
                                class="font-weight-bold"
                                text
                                >Cijena: {{ m.cijena }} KM
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </div>
        <my-footer></my-footer>
    </div>
</template>
<script>
export default {
    created() {
        this.dohvatiMeni();
    },
    data: () => ({
        meni: [],
        url: "/images/",
    }),
    methods: {
        dohvatiMeni() {
            axios
                .get("http://127.0.0.1:8000/meni")
                .then((response) => {
                    this.meni = response.data.meni;
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
    },
};
</script>
<style scoped>
.content {
    background-color: var(--bs-gray-100);
    font-family: sans-serif;
}
h1 {
    font-weight: 540;
    font-family: "ui-rounded";
}
</style>
