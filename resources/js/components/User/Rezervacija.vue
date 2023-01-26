<template>
    <div class="container">
        <v-alert v-if="rezervacijaDodana" type="success">
            Rezervacija uspješno dodana!
        </v-alert>
        <div class="box my-6 pr-10 white">
            <v-row>
                <v-col class="text-right py-0 pr-5">
                    <img
                        src="/images/slike/reserved.jpg"
                        width="100%"
                        height="100%"
                    />
                </v-col>
                <v-col class="pa-0">
                    <h3 class="my-5 font-weight-bold">Napravi Rezervaciju</h3>
                    <form @keydown="clearError">
                        <div class="mb-5">
                            <input
                                id="ime"
                                name="ime"
                                placeholder="Ime"
                                type="text"
                                v-model="form.ime"
                                class="form-control"
                                :class="hasError('ime') ? 'is-invalid' : ''"
                            />
                            <div
                                v-if="hasError('ime')"
                                class="invalid-feedback"
                            >
                                {{ getError("ime") }}
                            </div>
                        </div>

                        <div class="mb-5">
                            <input
                                id="prezime"
                                name="prezime"
                                placeholder="Prezime"
                                type="text"
                                v-model="form.prezime"
                                class="form-control"
                                :class="hasError('prezime') ? 'is-invalid' : ''"
                            />
                            <div
                                v-if="hasError('prezime')"
                                class="invalid-feedback"
                            >
                                {{ getError("prezime") }}
                            </div>
                        </div>

                        <div class="mb-5">
                            <input
                                id="email"
                                name="email"
                                placeholder="Email"
                                type="email"
                                v-model="form.email"
                                class="form-control"
                                :class="hasError('email') ? 'is-invalid' : ''"
                            />
                            <div
                                v-if="hasError('email')"
                                class="invalid-feedback"
                            >
                                {{ getError("email") }}
                            </div>
                        </div>

                        <div class="mb-5">
                            <input
                                id="broj_telefona"
                                name="broj_telefona"
                                placeholder="Broj telefona"
                                type="integer"
                                v-model="form.broj_telefona"
                                class="form-control"
                                :class="
                                    hasError('broj_telefona')
                                        ? 'is-invalid'
                                        : ''
                                "
                            />
                            <div
                                v-if="hasError('broj_telefona')"
                                class="invalid-feedback"
                            >
                                {{ getError("broj_telefona") }}
                            </div>
                        </div>

                        <div class="mb-5">
                            <input
                                @change="clearError"
                                id="datum_rezervacije"
                                name="datum_rezervacije"
                                class="form-control"
                                type="datetime-local"
                                v-model="form.datum_rezervacije"
                                :class="
                                    hasError('datum_rezervacije')
                                        ? 'is-invalid'
                                        : ''
                                "
                            />
                            <div
                                v-if="hasError('datum_rezervacije')"
                                class="invalid-feedback"
                            >
                                {{ getError("datum_rezervacije") }}
                            </div>
                        </div>

                        <div class="mb-5">
                            <input
                                id="broj_gostiju"
                                name="broj_gostiju"
                                placeholder="Broj gostiju"
                                type="integer"
                                v-model="form.broj_gostiju"
                                class="form-control"
                                :class="
                                    hasError('broj_gostiju') ? 'is-invalid' : ''
                                "
                            />
                            <div
                                v-if="hasError('broj_gostiju')"
                                class="invalid-feedback"
                            >
                                {{ getError("broj_gostiju") }}
                            </div>
                        </div>
                        <div class="mb-5">
                            <select
                                @change="clearError"
                                id="stol_id"
                                name="stol_id"
                                aria-label="Default select example"
                                v-model="form.stol_id"
                                class="form-select"
                                :class="hasError('stol_id') ? 'is-invalid' : ''"
                            >
                                <option selected value="">
                                    Odaberite stol
                                </option>
                                <option
                                    v-for="stol in stolovi"
                                    :key="stol.id"
                                    :value="stol.id"
                                >
                                    {{ stol.naziv }} ({{ stol.broj_gostiju }})
                                </option>
                            </select>
                            <div
                                v-if="hasError('stol_id')"
                                class="invalid-feedback"
                            >
                                {{ getError("stol_id") }}
                            </div>
                        </div>

                        <v-btn
                            color="success"
                            class="mr-4 mb-5"
                            @click="dodajRezervaciju"
                        >
                            REZERVIRAJ
                        </v-btn>
                    </form>
                </v-col>
            </v-row>
        </div>
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
                .post("http://127.0.0.1:8000/user/rezervacija/dodaj", this.form)
                .then(() => {
                    this.rezervacijaDodana = true;
                    setTimeout(() => {
                        this.rezervacijaDodana = false;
                        this.clearForm();
                        window.location = "http://127.0.0.1:8000/user";
                    }, 3000);
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
<style scoped>
.box {
    box-shadow: 2px 2px 5px grey;
    height: 100%;
}
.container {
    width: 70%;
}
</style>
