<template>
    <div>
        <v-alert v-if="stolDodan" type="success">
            Stol uspješno dodan!
        </v-alert>
        <v-form>
            <v-text-field label="Naziv" v-model="form.naziv"></v-text-field>
            <span class="text-danger" v-show="stolError.naziv"
                >Unesite naziv!</span
            >

            <v-text-field
                label="Broj gostiju"
                type="integer"
                v-model="form.broj_gostiju"
            ></v-text-field>
            <span class="text-danger" v-show="stolError.broj_gostiju"
                >Odaberite status stola!</span
            >
            <v-select
                placeholder="Status"
                v-model="form.status"
                :options="status"
            ></v-select>

            <span class="text-danger" v-show="stolError.status">Obavezno</span>
        </v-form>
        <v-btn @click="dodajStol()">Dodaj</v-btn>
    </div>
</template>

<script>
export default {
    data: () => ({
        form: {
            naziv: "",
            broj_gostiju: "",
            status: "",
        },
        stolError: {
            naziv: false,
            broj_gostiju: false,
            status: false,
        },
        status: ["Dostupan", "Nedostupan"],
        stolDodan: false,
    }),
    methods: {
        dodajStol() {
            this.form.naziv == ""
                ? (this.stolError.naziv = true)
                : (this.stolError.naziv = false);
            this.form.broj_gostiju == ""
                ? (this.stolError.broj_gostiju = true)
                : (this.stolError.broj_gostiju = false);
            this.form.status == ""
                ? (this.stolError.status = true)
                : (this.stolError.status = false);

            if (this.form.naziv && this.form.broj_gostiju && this.form.status) {
                axios
                    .post(
                        "http://127.0.0.1:8000/admin/stolovi/dodaj",
                        this.form
                    )
                    .then(() => {
                        this.stolDodan = true;
                        setTimeout(() => {
                            this.stolDodan = false;
                            this.clearForm();
                        }, 7000);
                        console.log("stol dodan");
                    })
                    .catch((e) => {
                        console.log("Nešto pošlo krivo! Greška=" + e);
                    });
            }
        },
        clearForm() {
            this.form.naziv = "";
            this.form.broj_gostiju = "";
            this.form.status = "";
        },
    },
};
</script>
