<template>
    <div>
        <v-alert v-if="stolIzbrisan" type="success">
            Stol uspješno izbrisan!
        </v-alert>
        <div>
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Naziv</th>
                            <th>Broj gostiju</th>
                            <th>Status</th>
                            <th>Uredi/Briši</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="stol in stolovi" :key="stol.id">
                            <td>{{ stol.naziv }}</td>
                            <td>{{ stol.broj_gostiju }}</td>
                            <td>{{ stol.status }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#stolModal"
                                    @click="dohvatiStol(stol)"
                                >
                                    Uredi
                                </button>
                                <button
                                    @click="izbrisiStol(stol.id)"
                                    class="btn btn-sm btn-danger"
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
            id="stolModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="stolModalLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stolModalLabel">Uredi</h5>
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
                                id="naziv"
                                name="naziv"
                                placeholder="Naziv"
                                type="text"
                                v-model="form.naziv"
                                class="form-control"
                                :class="hasError('naziv') ? 'is-invalid' : ''"
                            />
                            <div
                                v-if="hasError('naziv')"
                                class="invalid-feedback"
                            >
                                {{ getError("naziv") }}
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

                            <select
                                @change="clearError"
                                id="status"
                                name="status"
                                v-model="form.status"
                                class="form-select"
                                :class="hasError('status') ? 'is-invalid' : ''"
                            >
                                <option value="Dostupan">Dostupan</option>
                                <option value="Nedostupan">Nedostupan</option>
                            </select>
                            <div
                                v-if="hasError('status')"
                                class="invalid-feedback"
                            >
                                {{ getError("status") }}
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <v-alert v-if="stolSpremljen" type="success"
                            >Stol uspješno uređen!</v-alert
                        >
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Zatvori
                        </button>
                        <button
                            @click="spremiStol()"
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
        this.dohvatiStolove();
        console.log(this.MIX_APP_URL);
    },
    data: () => ({
        stolovi: [],
        form: {
            id: "",
            naziv: "",
            broj_gostiju: "",
            status: "",
        },
        loading: false,
        stolSpremljen: false,
        stolIzbrisan: false,
        errors: {},
    }),
    methods: {
        dohvatiStolove() {
            this.loading = true;
            axios
                .get("http://127.0.0.1:8000/stolovi")
                .then((response) => {
                    this.loading = false;
                    this.stolovi = response.data.stolovi;
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
        dohvatiStol(stol) {
            this.stolSpremljen = false;
            this.form = {
                id: stol.id,
                naziv: stol.naziv,
                broj_gostiju: stol.broj_gostiju,
                status: stol.status,
            };
        },
        spremiStol() {
            axios
                .post(
                    "http://127.0.0.1:8000/admin/stolovi/uredi/" + this.form.id,
                    this.form
                )
                .then(() => {
                    this.stolSpremljen = true;
                    setTimeout(() => {
                        this.stolSpremljen = false;
                    }, 4000);
                    this.dohvatiStolove();
                    console.log("Stol je dodan!");
                })
                .catch((e) => {
                    if (e.response.status == 422) {
                        this.errors = e.response.data.errors;
                    }
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
        izbrisiStol(id) {
            axios
                .get("http://127.0.0.1:8000/admin/stolovi/izbrisi/" + id)
                .then(() => {
                    this.dohvatiStolove();
                    this.stolIzbrisan = true;
                    setTimeout(() => {
                        this.stolIzbrisan = false;
                    }, 4000);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        hasError(fieldName) {
            return fieldName in this.errors;
        },
        getError(fieldName) {
            return this.errors[fieldName][0];
        },
        clearError(event) {
            delete this.errors[event.target.name];
        },
    },
};
</script>
