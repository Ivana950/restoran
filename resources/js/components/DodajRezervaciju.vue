<template>
    <div>
        <v-alert v-if="rezervacijaDodana" type="success">
            Meni uspješno dodan!
        </v-alert>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-text-field
                label="Ime"
                v-model="form.ime"
                :rules="nameRules"
                required
            ></v-text-field>
            <v-text-field
                label="Prezime"
                v-model="form.prezime"
                :rules="lastNameRules"
                required
            ></v-text-field>
            <v-text-field
                label="Email"
                v-model="form.email"
                :rules="emailRules"
                required
            ></v-text-field>
            <v-text-field
                type="integer"
                label="Broj telefona"
                v-model="form.broj_telefona"
                :rules="telephoneRules"
                required
            ></v-text-field>

            <input type="datetime-local" v-model="form.datum_rezervacije" />

            <v-text-field
                id="broj_gostiju"
                name="broj_gostiju"
                label="Broj gostiju"
                type="integer"
                v-model="form.broj_gostiju"
            ></v-text-field>

            <select
                id="stol_id"
                name="stol_id"
                v-model="form.stol"
                class="form-select"
                aria-label="Default select example"
            >
                <option v-for="stol in stolovi" :key="stol.id" value="stol_id">
                    {{ stol.naziv }} ({{ stol.broj_gostiju }})
                </option>
            </select>
            <br />

            <v-btn
                :disabled="!valid"
                color="success"
                class="mr-4"
                @click="validate"
            >
                Spremi
            </v-btn>
        </v-form>
    </div>
</template>

<script>
export default {
    created() {
        this.dohvatiStolove();
    },
    data: () => ({
        valid: true,
        nameRules: [
            (v) => !!v || "Unesite ime!",
            (v) => (v && v.length <= 20) || "Maksimalno 20 slova",
        ],
        lastNameRules: [
            (v) => !!v || "Unesite prezime!",
            (v) => (v && v.length <= 20) || "Maksimalno 20 slova",
        ],
        emailRules: [
            (v) => !!v || "Unesite e-mail",
            (v) => /.+@.+\..+/.test(v) || "Neispravni podaci",
        ],
        telephoneRules: [
            (v) => !!v || "Unesite broj telefona!",
            (v) => (v && v.length <= 20) || "Maksimalno 20 brojeva",
        ],
        dateRules: [
            (v) => !!v || "Izaberite datum!",
            (v) => (v && v.length <= 20) || "Maksimalno 20 slova",
        ],
        form: {
            ime: "",
            prezime: "",
            email: "",
            broj_telefona: "",
            datum_rezervacije: "",
            broj_gostiju: "",
            stol: "",
        },
        stolovi: [],
        rezervacijaDodana: false,
    }),
    methods: {
        validate() {
            this.$refs.form.validate();
            axios
                .post(
                    "http://127.0.0.1:8000/admin/rezervacije/dodaj",
                    this.form
                )
                .then(() => {
                    this.rezervacijaDodana = true;
                    console.log("rezervacija dodana");
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
        dohvatiStolove() {
            axios
                .get("http://127.0.0.1:8000/stolovi")
                .then((response) => {
                    this.stolovi = response.data.stolovi;
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
    },
};
</script>
