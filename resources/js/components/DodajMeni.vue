<template>
    <div>
        <v-alert v-if="meniDodan" type="success">
            Meni uspješno dodan!
        </v-alert>
        <form>
            <v-text-field label="Naziv" v-model="form.naziv"></v-text-field>
            <span class="text-danger" v-show="meniError.naziv"
                >Unesite naziv!</span
            >

            <v-text-field label="Opis" v-model="form.opis"></v-text-field>
            <span class="text-danger" v-show="meniError.opis"
                >Unesite opis!</span
            >

            <input
                type="file"
                id="slika"
                name="slika"
                class="form-control"
                @change="izabranaSlika"
            />
            <img
                :src="`${form.slika}`"
                class="figure-img img-fluid"
                style="max-height: 300px"
            />

            <v-text-field label="Cijena" v-model="form.cijena"></v-text-field>
            <span class="text-danger" v-show="meniError.cijena"
                >Unesite cijenu!</span
            >
        </form>
        <v-btn @click="dodajMeni()">Dodaj</v-btn>
    </div>
</template>

<script>
export default {
    data: () => ({
        form: {
            naziv: "",
            opis: "",
            cijena: "",
            slika: "",
        },
        meniDodan: false,
        meniError: {
            naziv: false,
            opis: false,
            cijena: false,
        },
    }),
    methods: {
        izabranaSlika(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                this.form.slika = reader.result;
            };
            reader.readAsDataURL(file);
        },
        dodajMeni() {
            this.form.naziv == ""
                ? (this.meniError.naziv = true)
                : (this.meniError.naziv = false);
            this.form.opis == ""
                ? (this.meniError.opis = true)
                : (this.meniError.opis = false);
            this.form.cijena == ""
                ? (this.meniError.cijena = true)
                : (this.meniError.cijena = false);

            if (this.form.naziv && this.form.opis && this.form.cijena) {
                axios
                    .post("http://127.0.0.1:8000/admin/meni/dodaj", this.form)
                    .then((response) => {
                        this.meniDodan = true;
                        setTimeout(() => {
                            this.meniDodan = false;
                            this.clearForm();
                        }, 7000);
                        console.log(response.data);
                    })
                    .catch((e) => {
                        console.log("Nešto pošlo krivo! Greška=" + e);
                    });
            }
        },
        clearForm() {
            this.form.naziv = "";
            this.form.opis = "";
            this.form.cijena = "";
            this.form.slika = "";
        },
    },
};
</script>
