<template>
    <div class="container">
        <v-alert v-if="stolIzbrisan" type="success">
            Stol uspješno izbrisan!
        </v-alert>
        <div>
            <v-row>
                <v-col class="text-right">
                    <v-btn
                        class="my-4"
                        color="primary"
                        width="150px"
                        @click="dodajStol()"
                        >DODAJ STOL</v-btn
                    >
                </v-col>
            </v-row>

            <div class="card-body table-responsive mb-16 text-center">
                <table class="table">
                    <thead class="white--text">
                        <tr class="blue">
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
                            <td>
                                <v-chip
                                    class="ma-2"
                                    :color="
                                        stol.status === 'Dostupan'
                                            ? 'green'
                                            : 'red'
                                    "
                                    text-color="white"
                                    >{{ stol.status }}
                                </v-chip>
                            </td>
                            <td>
                                <v-btn
                                    color="primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#stolModal"
                                    @click="dohvatiStol(stol)"
                                >
                                    <v-icon left> mdi-pencil </v-icon>
                                    Uredi
                                </v-btn>

                                <v-btn
                                    depressed
                                    color="error"
                                    @click="izbrisiStol(stol.id)"
                                >
                                    <v-icon left> mdi-delete </v-icon>
                                    Izbriši
                                </v-btn>
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
                    <div class="modal-header blue white--text">
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
                    <div class="modal-body pa-5">
                        <form @keydown="clearError">
                            <div class="mb-5">
                                <input
                                    id="naziv"
                                    name="naziv"
                                    placeholder="Naziv"
                                    type="text"
                                    v-model="form.naziv"
                                    class="form-control"
                                    :class="
                                        hasError('naziv') ? 'is-invalid' : ''
                                    "
                                />
                                <div
                                    v-if="hasError('naziv')"
                                    class="invalid-feedback"
                                >
                                    {{ getError("naziv") }}
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
                                        hasError('broj_gostiju')
                                            ? 'is-invalid'
                                            : ''
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
                                    id="status"
                                    name="status"
                                    v-model="form.status"
                                    class="form-select"
                                    :class="
                                        hasError('status') ? 'is-invalid' : ''
                                    "
                                >
                                    <option value="Dostupan">Dostupan</option>
                                    <option value="Nedostupan">
                                        Nedostupan
                                    </option>
                                </select>
                                <div
                                    v-if="hasError('status')"
                                    class="invalid-feedback"
                                >
                                    {{ getError("status") }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <v-alert v-if="stolSpremljen" type="success"
                            >Stol uspješno uređen!</v-alert
                        >
                        <v-btn depressed color="error" data-bs-dismiss="modal">
                            ZATVORI
                        </v-btn>

                        <v-btn @click="spremiStol()" color="primary"
                            >SPREMI</v-btn
                        >
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
        dodajStol() {
            window.location = "http://127.0.0.1:8000/admin/stolovi/dodaj";
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
<style scoped>
.v-btn {
    font-size: 12px;
}
.container {
    width: 75%;
}
</style>
