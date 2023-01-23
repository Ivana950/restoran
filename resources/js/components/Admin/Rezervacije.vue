<template>
    <div>
        <v-alert v-if="rezervacijaIzbrisana" type="success">
            Rezervacija uspješno izbrisana!
        </v-alert>
        <div>
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>E-mail</th>
                            <th>Broj telefona</th>
                            <th>Datum rezervacije</th>
                            <th>Broj gostiju</th>
                            <th>Stol</th>
                            <th>Uredi/Briši</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="rezervacija in rezervacije"
                            :key="rezervacija.id"
                        >
                            <td>
                                {{ rezervacija.ime }}
                            </td>
                            <td>
                                {{ rezervacija.prezime }}
                            </td>
                            <td>
                                {{ rezervacija.email }}
                            </td>
                            <td>
                                {{ rezervacija.broj_telefona }}
                            </td>
                            <td>
                                {{ rezervacija.datum_rezervacije }}
                            </td>
                            <td>
                                {{ rezervacija.broj_gostiju }}
                            </td>
                            <td>
                                {{ rezervacija.stol.naziv }}
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rezervacijaModal"
                                    @click="dohvatiRezervaciju(rezervacija)"
                                >
                                    <i class="fa fa-edit"></i> Uredi
                                </button>
                                <button
                                    class="btn btn-sm btn-danger"
                                    @click="izbrisiRezervaciju(rezervacija)"
                                >
                                    <i class="fa fa-trash"></i> Izbriši
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <loading :loading="loading"></loading>
        <div
            class="modal fade"
            id="rezervacijaModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="rezervacijaModalLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rezervacijaModalLabel">
                            Uredi
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                            <div
                                v-if="hasError('ime')"
                                class="invalid-feedback"
                            >
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
                            <div
                                v-if="hasError('prezime')"
                                class="invalid-feedback"
                            >
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
                            <div
                                v-if="hasError('email')"
                                class="invalid-feedback"
                            >
                                {{ getError("email") }}
                            </div>
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
                            <input
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

                            <v-autocomplete
                                @change="clearError"
                                id="stol_id"
                                label="Stol"
                                v-model="form.stol_id"
                                :items="stolovi"
                                item-text="naziv"
                                item-value="id"
                                class="form-control"
                                :class="hasError('stol_id') ? 'is-invalid' : ''"
                            ></v-autocomplete>
                            <div
                                v-if="hasError('stol_id')"
                                class="invalid-feedback"
                            >
                                {{ getError("stol_id") }}
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <v-alert v-if="rezervacijaSpremljena" type="success"
                            >Rezervacija uspješno uređena!</v-alert
                        >
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Zatvori
                        </button>
                        <button
                            @click="spremiRezervaciju()"
                            type="button"
                            class="btn btn-primary"
                        >
                            Spremi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        this.dohvatiRezervacije();
        this.dohvatiStolove();
    },
    data: () => ({
        rezervacije: [],
        stolovi: [],
        loading: false,
        form: {
            id: "",
            ime: "",
            prezime: "",
            email: "",
            broj_telefona: "",
            datum_rezervacije: "",
            broj_gostiju: "",
            stol_id: "",
        },
        brisiRezervaciju: {
            id: "",
            stol_id: "",
        },
        errors: {},
        rezervacijaSpremljena: false,
        rezervacijaIzbrisana: false,
    }),
    methods: {
        dohvatiRezervacije() {
            this.loading = true;
            axios
                .get("http://127.0.0.1:8000/rezervacije")
                .then((response) => {
                    this.loading = false;
                    this.rezervacije = response.data.rezervacija;
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
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
        dohvatiRezervaciju(rezervacija) {
            this.rezervacijaSpremljena = false;
            this.form = {
                id: rezervacija.id,
                ime: rezervacija.ime,
                prezime: rezervacija.prezime,
                email: rezervacija.email,
                broj_telefona: rezervacija.broj_telefona,
                datum_rezervacije: rezervacija.datum_rezervacije,
                broj_gostiju: rezervacija.broj_gostiju,
                stol_id: rezervacija.stol_id,
            };
        },
        spremiRezervaciju() {
            axios
                .post(
                    "http://127.0.0.1:8000/admin/rezervacije/uredi/" +
                        this.form.id,
                    this.form
                )
                .then(() => {
                    this.rezervacijaSpremljena = true;
                    setTimeout(() => {
                        this.rezervacijaSpremljena = false;
                    }, 4000);
                    this.dohvatiRezervacije();
                    console.log("Rezervacija dodana!");
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
        izbrisiRezervaciju(rezervacija) {
            this.brisiRezervaciju = {
                id: rezervacija.id,
                stol_id: rezervacija.stol_id,
            };
            axios
                .post(
                    "http://127.0.0.1:8000/admin/rezervacije/izbrisi/" +
                        this.brisiRezervaciju.id,
                    this.brisiRezervaciju
                )
                .then(() => {
                    this.rezervacijaIzbrisana = true;
                    setTimeout(() => {
                        this.rezervacijaIzbrisana = false;
                    }, 4000);
                    this.dohvatiRezervacije();
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
