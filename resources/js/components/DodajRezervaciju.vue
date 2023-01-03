<template>
    <div>
        <v-alert v-if="rezervacijaDodana" type="success">
            Rezervacija uspješno dodana!
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
            <span
                class="text-danger"
                v-show="rezervacijaError.datum_rezervacije"
                >Izaberite datum i vrijeme rezervacije!</span
            >

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
                v-model="form.stol_id"
                class="form-select"
                aria-label="Default select example"
            >
                <option selected value="">Odaberite stol</option>
                <option v-for="stol in stolovi" :key="stol.id" :value="stol.id">
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
        form: {
            ime: "",
            prezime: "",
            email: "",
            broj_telefona: "",
            datum_rezervacije: "",
            broj_gostiju: "",
            stol_id: "",
        },
        stolovi: [],
        rezervacijaDodana: false,
        rezervacijaError: {
            datum_rezervacije: false,
        },
    }),
    methods: {
        validate() {
            this.form.datum_rezervacije == ""
                ? (this.rezervacijaError.datum_rezervacije = true)
                : (this.rezervacijaError.datum_rezervacije = false);
            if (this.$refs.form.validate() && this.form.datum_rezervacije) {
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
            }
        },
        dohvatiStolove() {
            axios
                .get("http://127.0.0.1:8000/slobodniStolovi")
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
