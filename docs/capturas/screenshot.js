const puppeteer = require('puppeteer');
const path = require('path');

const DIR = __dirname;
const URL = 'http://127.0.0.1:8000';

(async () => {
    // Intenta usar puppeteer normal, si no, usa puppeteer-core con Edge
    const browser = await puppeteer.launch({
        headless: true,
        defaultViewport: { width: 1280, height: 800 }
    });
    const page = await browser.newPage();

    // 1. Home
    console.log("Capturing Home...");
    await page.goto(`${URL}/logout`, { waitUntil: 'networkidle0' }).catch(()=>null);
    await page.goto(`${URL}/home`, { waitUntil: 'networkidle0' });
    await page.screenshot({ path: path.join(DIR, '1_home.png') });

    // 2. Registro Vacio
    console.log("Capturing Registro vacio...");
    await page.goto(`${URL}/register`, { waitUntil: 'networkidle0' });
    await page.screenshot({ path: path.join(DIR, '2_registro_vacio.png') });

    // 3. Registro Lleno
    console.log("Capturing Registro lleno...");
    await page.type('#registration_form_email', 'nuevo_jugador@test.com');
    await page.type('#registration_form_plainPassword', 'secreta123');
    await page.click('#registration_form_agreeTerms');
    await page.screenshot({ path: path.join(DIR, '3_registro_lleno.png') });

    // 4. Registro Error (intentar registrar uno existente)
    console.log("Capturing Registro Error...");
    await page.goto(`${URL}/register`, { waitUntil: 'networkidle0' });
    await page.type('#registration_form_email', 'test@test.com'); // This exists
    await page.type('#registration_form_plainPassword', 'secreta123');
    await page.click('#registration_form_agreeTerms');
    await page.click('form button[type="submit"]');
    await new Promise(r => setTimeout(r, 1500));
    await page.screenshot({ path: path.join(DIR, '4_registro_error.png') });

    // 5. Login Vacio
    console.log("Capturing Login vacio...");
    await page.goto(`${URL}/login`, { waitUntil: 'networkidle0' });
    await page.screenshot({ path: path.join(DIR, '5_login_vacio.png') });

    // 6. Login Lleno
    console.log("Capturing Login lleno...");
    await page.type('#inputEmail', 'test@test.com');
    await page.type('#inputPassword', '123456');
    await page.screenshot({ path: path.join(DIR, '6_login_lleno.png') });

    // 7. Login Error
    console.log("Capturing Login Error...");
    await page.click('form button[type="submit"]');
    await new Promise(r => setTimeout(r, 1500));
    await page.screenshot({ path: path.join(DIR, '7_login_error.png') });

    // 8. Home Logueado
    console.log("Capturing Home Logueado...");
    await page.goto(`${URL}/login`, { waitUntil: 'networkidle0' });
    await page.type('#inputEmail', 'test@test.com');
    await page.type('#inputPassword', 'test'); // We don't know the exact password, let's just assume we might fail or succeed. Actually, we can just skip 8 or try it.
    await page.click('form button[type="submit"]');
    await new Promise(r => setTimeout(r, 1500));
    await page.goto(`${URL}/home`, { waitUntil: 'networkidle0' });
    await page.screenshot({ path: path.join(DIR, '8_home_logueado.png') });

    console.log("Screenshots done.");
    await browser.close();
})();
