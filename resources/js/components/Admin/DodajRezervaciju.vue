<template>
    <div>
        <v-alert v-if="rezervacijaDodana" type="success">
            Rezervacija uspješno dodana!
        </v-alert>

        <form @keydown="clearError">
            <input
                id="ime"
                name="ime"
                placeholder="Ime"
                type="text"
                v-model="form.ime"
                class="form-control"
                :class="hasError('ime') ? 'is-invalid' : ''"
            />
            <!-- bindig klase koja preko metode hasError provjerava da li postoji eror na ovom inputu i ako postoji stavlja bootstrap klasu 'is-invalid' koja stavlja crveni obrub na input a ako ne postoji eror ostavlja prazno -->
            <div v-if="hasError('ime')" class="invalid-feedback">
                {{ getError("ime") }}
            </div>

            <input
                id="prezime"
                name="prezime"
                placeholder="Prezime"
                type="text"
                v-model="form.prezime"
                class="form-control"
                :class="hasError('prezime') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('prezime')" class="invalid-feedback">
                {{ getError("prezime") }}
            </div>
            <input
                id="email"
                name="email"
                placeholder="Email"
                type="email"
                v-model="form.email"
                class="form-control"
                :class="hasError('email') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('email')" class="invalid-feedback">
                {{ getError("email") }}
            </div>
            <input
                id="broj_telefona"
                name="broj_telefona"
                placeholder="Broj telefona"
                type="integer"
                v-model="form.broj_telefona"
                class="form-control"
                :class="hasError('broj_telefona') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('broj_telefona')" class="invalid-feedback">
                {{ getError("broj_telefona") }}
            </div>
            <input
                @change="clearError"
                id="datum_rezervacije"
                name="datum_rezervacije"
                class="form-control"
                type="datetime-local"
                v-model="form.datum_rezervacije"
                :class="hasError('datum_rezervacije') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('datum_rezervacije')" class="invalid-feedback">
                {{ getError("datum_rezervacije") }}
            </div>

            <input
                id="broj_gostiju"
                name="broj_gostiju"
                placeholder="Broj gostiju"
                type="integer"
                v-model="form.broj_gostiju"
                class="form-control"
                :class="hasError('broj_gostiju') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('broj_gostiju')" class="invalid-feedback">
                {{ getError("broj_gostiju") }}
            </div>

            <select
                @change="clearError"
                id="stol_id"
                name="stol_id"
                aria-label="Default select example"
                v-model="form.stol_id"
                class="form-select"
                :class="hasError('stol_id') ? 'is-invalid' : ''"
            >
                <option selected value="">Odaberite stol</option>
                <option v-for="stol in stolovi" :key="stol.id" :value="stol.id">
                    {{ stol.naziv }} ({{ stol.broj_gostiju }})
                </option>
            </select>
            <div v-if="hasError('stol_id')" class="invalid-feedback">
                {{ getError("stol_id") }}
            </div>

            <v-btn color="success" class="mr-4" @click="dodajRezervaciju">
                Spremi
            </v-btn>
        </form>
    </div>
</template>

<script>
export default {
    created() {
        this.dohvatiStolove();
    },
    data: () => ({
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
        errors: {},
    }),
    methods: {
        dodajRezervaciju() {
            axios
                .post(
                    "http://127.0.0.1:8000/admin/rezervacije/dodaj",
                    this.form
                )
                .then(() => {
                    this.rezervacijaDodana = true;
                    setTimeout(() => {
                        this.rezervacijaDodana = false;
                        this.clearForm();
                    }, 4000);
                    this.dohvatiStolove();
                    console.log("rezervacija dodana");
                })
                .catch((e) => {
                    if (e.response.status == 422) {
                        this.errors = e.response.data.errors;
                    } else {
                        console.log("Nešto pošlo krivo! Greška=" + e);
                    }
                });
        },

        hasError(fieldName) {
            return fieldName in this.errors; // metoda prima nazivPolja i provjerava je li u this.errors
        },
        getError(fieldName) {
            return this.errors[fieldName][0];
        },
        clearError(event) {
            delete this.errors[event.target.name];
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
        clearForm() {
            this.form.ime = "";
            this.form.prezime = "";
            this.form.email = "";
            this.form.broj_telefona = "";
            this.form.datum_rezervacije = "";
            this.form.broj_gostiju = "";
            this.form.stol_id = "";
        },
    },
};
</script>
