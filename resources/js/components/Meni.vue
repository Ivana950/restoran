<template>
    <div>
        <div>
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
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
                                <img :src="`${url}${m.slika}`" width="80" />
                            </td>
                            <td>{{ m.cijena }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-warning"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#meniModal"
                                    @click="dohvatiMeni(m)"
                                >
                                    <i class="fa fa-edit"></i> Uredi
                                </button>
                                <button
                                    class="btn btn-sm btn-danger"
                                    @click="izbrisiMeni(m.id)"
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
                    <div class="modal-header">
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
                    <div class="modal-body">
                        <v-form>
                            <v-text-field
                                label="Naziv"
                                v-model="form.naziv"
                            ></v-text-field>
                            <span class="text-danger" v-show="meniError.naziv"
                                >Unesite naziv!</span
                            >

                            <v-text-field
                                label="Opis"
                                v-model="form.opis"
                            ></v-text-field>
                            <span class="text-danger" v-show="meniError.opis"
                                >Unesite opis!</span
                            >

                            <input
                                type="file"
                                id="slika"
                                class="form-control"
                                @change="izabranaSlika"
                            />
                            <img
                                :src="`${form.slika}`"
                                class="figure-img img-fluid"
                                style="max-height: 200px"
                            />

                            <v-text-field
                                placeholder="cijena"
                                v-model="form.cijena"
                            ></v-text-field>
                            <span class="text-danger" v-show="meniError.cijena"
                                >Unesite cijenu!</span
                            >
                        </v-form>
                    </div>
                    <div class="modal-footer">
                        <v-alert v-if="meniSpremljen" type="success"
                            >Meni uspješno uređen!</v-alert
                        >
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Zatvori
                        </button>
                        <button
                            @click="spremiMeni()"
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
        meniError: {
            naziv: false,
            opis: false,
            cijena: false,
        },
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
        izabranaSlika(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                this.form.slika = reader.result;
            };
            reader.readAsDataURL(file);
        },
        spremiMeni() {
            this.form.naziv == ""
                ? (this.meniError.naziv = true)
                : (this.meniError.naziv = false);
            this.form.opis == ""
                ? (this.meniError.opis = true)
                : (this.meniError.opis = false);
            this.form.cijena == ""
                ? (this.meniError.cijena = true)
                : (this.meniError.cijena = false);

            if (this.form.naziv && this.form.opis && this.form.cijena) {
                axios
                    .post(
                        "http://127.0.0.1:8000/admin/meni/uredi/" +
                            this.form.id,
                        this.form
                    )
                    .then(() => {
                        this.meniSpremljen = true;
                        this.dohvatiMenije();
                        console.log("Meni dodan!");
                    })
                    .catch((e) => {
                        console.log("Nešto pošlo krivo! Greška=" + e);
                    });
            }
        },
        izbrisiMeni(id) {
            axios
                .get("http://127.0.0.1:8000/admin/meni/izbrisi/" + id)
                .then((response) => {
                    this.dohvatiMenije();
                })
                .catch((e) => {
                    console.log("Nešto pošlo krivo! Greška=" + e);
                });
        },
    },
};
</script>
