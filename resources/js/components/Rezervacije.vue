<template>
    <div>
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
                        <v-form>
                            <v-text-field
                                label="Ime"
                                v-model="form.ime"
                            ></v-text-field>
                            <span
                                class="text-danger"
                                v-show="rezervacijaError.ime"
                                >Unesite naziv!</span
                            >

                            <v-text-field
                                label="Prezime"
                                v-model="form.prezime"
                            ></v-text-field>
                            <span
                                class="text-danger"
                                v-show="rezervacijaError.prezime"
                                >Unesite opis!</span
                            >

                            <v-text-field
                                label="Email"
                                v-model="form.email"
                            ></v-text-field>
                            <span
                                class="text-danger"
                                v-show="rezervacijaError.email"
                                >Unesite opis!</span
                            >
                            <v-text-field
                                label="Broj telefona"
                                v-model="form.broj_telefona"
                            ></v-text-field>
                            <span
                                class="text-danger"
                                v-show="rezervacijaError.broj_telefona"
                                >Unesite opis!</span
                            >
                            <input
                                type="datetime-local"
                                v-model="form.datum_rezervacije"
                            />
                            <v-text-field
                                label="Broj gostiju"
                                type="integer"
                                v-model="form.broj_gostiju"
                            ></v-text-field>
                            <span
                                class="text-danger"
                                v-show="rezervacijaError.broj_gostiju"
                                >Unesite opis!</span
                            >
                            <v-autocomplete
                                v-model="form.stol"
                                :items="stolovi"
                                item-text="naziv"
                                item-value="id"
                                label="Stol"
                            ></v-autocomplete>
                        </v-form>
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
            stol: "",
        },
        brisiRezervaciju: {
            id: "",
            stol: "",
        },
        rezervacijaError: {
            ime: false,
            prezime: false,
            email: false,
            broj_telefona: false,
            datum_rezervacije: false,
            broj_gostiju: false,
            stol: false,
        },
        rezervacijaSpremljena: false,
        rezervacijaIzbrisan: false,
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
                stol: rezervacija.stol_id,
            };
        },
        spremiRezervaciju() {
            this.form.ime == ""
                ? (this.rezervacijaError.ime = true)
                : (this.rezervacijaError.ime = false);
            this.form.prezime == ""
                ? (this.rezervacijaError.prezime = true)
                : (this.rezervacijaError.prezime = false);
            this.form.email == ""
                ? (this.rezervacijaError.email = true)
                : (this.rezervacijaError.email = false);
            this.form.broj_telefona == ""
                ? (this.rezervacijaError.broj_telefona = true)
                : (this.rezervacijaError.broj_telefona = false);
            this.form.datum_rezervacije == ""
                ? (this.rezervacijaError.datum_rezervacije = true)
                : (this.rezervacijaError.datum_rezervacije = false);
            this.form.broj_gostiju == ""
                ? (this.rezervacijaError.broj_gostiju = true)
                : (this.rezervacijaError.broj_gostiju = false);
            this.form.stol == ""
                ? (this.rezervacijaError.stol = true)
                : (this.rezervacijaError.stol = false);

            if (
                this.form.ime &&
                this.form.prezime &&
                this.form.email &&
                this.form.broj_telefona &&
                this.form.datum_rezervacije &&
                this.form.broj_gostiju &&
                this.form.stol
            ) {
                axios
                    .post(
                        "http://127.0.0.1:8000/admin/rezervacije/uredi/" +
                            this.form.id,
                        this.form
                    )
                    .then(() => {
                        this.rezervacijaSpremljena = true;
                        this.dohvatiRezervacije();
                        console.log("Rezervacija dodana!");
                    })
                    .catch((e) => {
                        console.log("Nešto pošlo krivo! Greška=" + e);
                    });
            }
        },
        izbrisiRezervaciju(rezervacija) {
            this.brisiRezervaciju = {
                id: rezervacija.id,
                stol: rezervacija.stol_id,
            };
            axios
                .post(
                    "http://127.0.0.1:8000/admin/rezervacije/izbrisi/" +
                        this.brisiRezervaciju.id,
                    this.brisiRezervaciju
                )
                .then((response) => {
                    this.dohvatiRezervacije();
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
    },
};
</script>
