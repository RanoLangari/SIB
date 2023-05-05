/**
 * @TODO
 * Lengkapilah kode di bawah ini agar dapat mengakses jalan tol.
 * 1. Beli kartu tol (buyTollRoadCard) -> isi argumen money dengan angka 25 -> mengembalikan objek { tollRoadCard: true, balance: 0 }.
 * 2. Isi saldo kartu tol (topUpBalance) -> isi argumen card dengan objek card yang didapat dari langkah 1 dan isi argumen amount dengan angka 10 -> mengembalikan objek { tollRoadCard: true, balance: 10 }.
 * 3. Gunakan akses jalan toll (useTollRoad) -> isi argumen card dengan objek card yang didapat dari langkah 2.
 *
 * Catatan:
 * - Anda boleh menggunakan async/await atau .then() atau .catch() atau kombinasi keduanya.
 * - Jika ada error, tampilkan error (error.message) tersebut dengan console.log.
 * - Masing-masing langkah di atas harus dijalankan secara berurutan.
 * - Masing-masing langkah akan mencetak pesan ke console.
 * - Anda bisa mengeksplorasi fungsi yang sudah disediakan di utils.js. Namun, Anda tidak boleh mengubah isi dari utils.js.
 */

// - Pastikan console menghasilkan output yang tepat jika seluruh tahapan berhasil dilakukan
// - Pastikan Anda menangani kondisi promise yang berstatus rejected

const { buyTollRoadCard, topUpBalance, useTollRoad } = require("./utils");

// TODO
// 1. Beli kartu tol (buyTollRoadCard) -> isi argumen money dengan angka 25 -> mengembalikan objek { tollRoadCard: true, balance: 0 }.
// 2. Isi saldo kartu tol (topUpBalance) -> isi argumen card dengan objek card yang didapat dari langkah 1 dan isi argumen amount dengan angka 10 -> mengembalikan objek { tollRoadCard: true, balance: 10 }.
// 3. Gunakan akses jalan toll (useTollRoad) -> isi argumen card dengan objek card yang didapat dari langkah 2.

async function getTollAccess() {
  try {
    const card = await buyTollRoadCard(25);
    const balance = await topUpBalance(card, 10);
    const result = await useTollRoad(balance);
  } catch (error) {
    console.log(error.message);
  }
}

// - Pastikan console menghasilkan output yang tepat jika seluruh tahapan berhasil dilakukan
// - Pastikan Anda menangani kondisi promise yang berstatus rejected

// const { buyTollRoadCard, topUpBalance, useTollRoad } = require("./utils");

// // TODO

// // 1. Beli kartu tol (buyTollRoadCard) -> isi argumen money dengan angka 25 -> mengembalikan objek { tollRoadCard: true, balance: 0 }.
// // 2. Isi saldo kartu tol (topUpBalance) -> isi argumen card dengan objek card yang didapat dari langkah 1 dan isi argumen amount dengan angka 10 -> mengembalikan objek { tollRoadCard: true, balance: 10 }.
// // 3. Gunakan akses jalan toll (useTollRoad) -> isi argumen card dengan objek card yang didapat dari langkah 2.



//
// function getTollAccess() {
//   buyTollRoadCard(25)
//     .then((card) => {
//       return topUpBalance(card, 10);
//     })
//     .then((balance) => {
//       return useTollRoad(balance);
//     })
//     .catch((error) => {
//       console.log(error.message);
//     });
// }



getTollAccess();

// Path: utils.js
// /**
//  * @TODO
//  * Ubahlah fungsi asynchronous callback-based buyTollRoadCard menjadi Promise-based.

//  * Catatan:
//  * - Anda boleh menggunakan util.promisify untuk mengubah fungsi callback-based menjadi Promise-based.
//  * - Jika nama fungsinya berubah, sesuaikan nilai yang diekspor tanpa mengubah nama properti di akhir berkas ini.
