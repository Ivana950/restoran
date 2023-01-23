<template>
    <div>
        <v-alert v-if="meniDodan" type="success">
            Meni uspješno dodan!
        </v-alert>
        <form @keydown="clearError" @change="clearError">
            <input
                id="naziv"
                name="naziv"
                placeholder="Naziv"
                type="text"
                v-model="form.naziv"
                class="form-control"
                :class="hasError('naziv') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('naziv')" class="invalid-feedback">
                {{ getError("naziv") }}
            </div>

            <input
                id="opis"
                name="opis"
                placeholder="Opis"
                type="text"
                v-model="form.opis"
                class="form-control"
                :class="hasError('opis') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('opis')" class="invalid-feedback">
                {{ getError("opis") }}
            </div>

            <input
                type="file"
                id="slika"
                name="slika"
                class="form-control"
                @change="izabranaSlika"
                :class="hasError('slika') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('slika')" class="invalid-feedback">
                {{ getError("slika") }}
            </div>
            <img
                :src="`${form.slika}`"
                class="figure-img img-fluid"
                style="max-height: 300px"
            />

            <input
                id="cijena"
                name="cijena"
                placeholder="Cijena"
                type="integer"
                v-model="form.cijena"
                class="form-control"
                :class="hasError('cijena') ? 'is-invalid' : ''"
            />
            <div v-if="hasError('cijena')" class="invalid-feedback">
                {{ getError("cijena") }}
            </div>
        </form>
        <v-btn @click="dodajMeni()">Dodaj</v-btn>
    </div>
</template>

<script>
export default {
    data: () => ({
        form: {
            naziv: "",
            opis: "",
            cijena: "",
            slika: "",
        },
        meniDodan: false,
        errors: {},
    }),
    methods: {
        izabranaSlika(event) {
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                this.form.slika = reader.result;
                console.log(reader.result);
            };
            reader.readAsDataURL(file);
        },
        dodajMeni() {
            axios
                .post("http://127.0.0.1:8000/admin/meni/dodaj", this.form)
                .then(() => {
                    this.meniDodan = true;
                    setTimeout(() => {
                        this.meniDodan = false;
                        this.clearForm();
                    }, 4000);
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
        clearForm() {
            this.form.naziv = "";
            this.form.opis = "";
            this.form.cijena = "";
            this.form.slika = "";
        },
    },
};
</script>
