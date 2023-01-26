<template>
    <div class="container">
        <v-alert v-if="meniIzbrisan" type="success">
            Meni uspješno izbrisan!
        </v-alert>

        <div>
            <v-row>
                <v-col class="text-right">
                    <v-btn
                        class="mt-4 mb-4"
                        color="primary"
                        width="110px"
                        @click="dodajMeni()"
                        >DODAJ MENI</v-btn
                    >
                </v-col>
            </v-row>

            <div class="card-body table-responsive text-center">
                <table class="table">
                    <thead class="white--text">
                        <tr class="blue">
                            <th>Naziv</th>
                            <th>Opis</th>
                            <th>Slika</th>
                            <th>Cijena</th>
                            <th>Uredi/Briši</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="m in meni" :key="m.id">
                            <td>
                                {{ m.naziv }}
                            </td>
                            <td>{{ m.opis }}</td>
                            <td>
                                <img :src="`${url}${m.slika}`" width="150" />
                            </td>
                            <td>{{ m.cijena }}</td>
                            <td>
                                <v-btn
                                    color="primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#meniModal"
                                    @click="dohvatiMeni(m)"
                                >
                                    <v-icon left> mdi-pencil </v-icon>
                                    Uredi
                                </v-btn>

                                <v-btn
                                    depressed
                                    color="error"
                                    @click="izbrisiMeni(m.id)"
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
            id="meniModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="meniModalLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header blue white--text">
                        <h5 class="modal-title" id="meniModalLabel">Uredi</h5>
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
                        <form @keydown="clearError" @change="clearError">
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
                                    id="opis"
                                    name="opis"
                                    placeholder="Opis"
                                    type="text"
                                    v-model="form.opis"
                                    class="form-control"
                                    :class="
                                        hasError('opis') ? 'is-invalid' : ''
                                    "
                                />
                                <div
                                    v-if="hasError('opis')"
                                    class="invalid-feedback"
                                >
                                    {{ getError("opis") }}
                                </div>
                            </div>
                            <div class="mb-5">
                                <input
                                    type="file"
                                    id="slika"
                                    name="slika"
                                    class="form-control"
                                    @change="izabranaSlika"
                                    :class="
                                        hasError('slika') ? 'is-invalid' : ''
                                    "
                                />
                                <div
                                    v-if="hasError('slika')"
                                    class="invalid-feedback"
                                >
                                    {{ getError("slika") }}
                                </div>
                            </div>

                            <img
                                :src="`${form.slika}`"
                                class="figure-img img-fluid"
                                style="max-height: 300px"
                            />

                            <div class="mb-5">
                                <input
                                    id="cijena"
                                    name="cijena"
                                    placeholder="Cijena"
                                    type="integer"
                                    v-model="form.cijena"
                                    class="form-control"
                                    :class="
                                        hasError('cijena') ? 'is-invalid' : ''
                                    "
                                />
                                <div
                                    v-if="hasError('cijena')"
                                    class="invalid-feedback"
                                >
                                    {{ getError("cijena") }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <v-alert v-if="meniSpremljen" type="success"
                            >Meni uspješno uređen!</v-alert
                        >
                        <v-btn depressed color="error" data-bs-dismiss="modal">
                            ZATVORI
                        </v-btn>
                        <v-btn @click="spremiMeni()" color="primary"
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
        this.dohvatiMenije();
    },
    data: () => ({
        meni: [],
        loading: false,
        url: "/images/",
        form: {
            id: "",
            naziv: "",
            opis: "",
            cijena: "",
            slika: "",
        },
        errors: {},
        meniSpremljen: false,
        meniIzbrisan: false,
    }),
    methods: {
        dohvatiMenije() {
            this.loading = true;
            axios
                .get("http://127.0.0.1:8000/meni")
                .then((response) => {
                    this.loading = false;
                    this.meni = response.data.meni;
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
        dohvatiMeni(meni) {
            this.meniSpremljen = false;
            this.form = {
                id: meni.id,
                naziv: meni.naziv,
                opis: meni.opis,
                cijena: meni.cijena,
                slika: "",
            };
        },
        dodajMeni() {
            window.location = "http://127.0.0.1:8000/admin/meni/dodaj";
        },
        izabranaSlika(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                this.form.slika = reader.result;
            };
            reader.readAsDataURL(file);
        },
        spremiMeni() {
            axios
                .post(
                    "http://127.0.0.1:8000/admin/meni/uredi/" + this.form.id,
                    this.form
                )
                .then(() => {
                    this.meniSpremljen = true;
                    setTimeout(() => {
                        this.meniSpremljen = false;
                    }, 4000);

                    this.dohvatiMenije();
                    console.log("Meni dodan!");
                })
                .catch((e) => {
                    if (e.response.status == 422) {
                        this.errors = e.response.data.errors;
                    }
                    console.log("Nešto pošlo krivo! Greška=" + e);
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
        izbrisiMeni(id) {
            axios
                .get("http://127.0.0.1:8000/admin/meni/izbrisi/" + id)
                .then(() => {
                    this.dohvatiMenije();
                    this.meniIzbrisan = true;
                    setTimeout(() => {
                        this.meniIzbrisan = false;
                    }, 4000);
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
    },
};
</script>
<style scoped>
.v-btn {
    font-size: 12px;
}
.container {
    width: 85%;
}
</style>
