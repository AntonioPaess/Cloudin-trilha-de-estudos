const puppeteer = require('puppeteer');
const fs = require('fs');

async function getMare() {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    try {
        console.log('Acessando a página...');
        await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        await page.goto('https://surfguru.com.br/previsao/mare/30955', { waitUntil: 'networkidle2' });

        console.log('Aguardando carregamento dos elementos...');
        await page.waitForSelector('.linha_dia', { timeout: 5000 });

        
        const html = await page.content();

        
        const cheerio = require('cheerio');
        const $ = cheerio.load(html);

        
        const dias = $('.linha_dia').has('.celula_dia');
        console.log(`Elementos encontrados: ${dias.length}`);

        if (dias.length === 0) {
            console.log('Nenhum dado encontrado. Verifique a estrutura do HTML.');
            return;
        }

        
        const dados = {
            noronha: {
                2025: {
                    2: {}, // mudar para o mês atual
                    3: {}  // mudar para o próximo mês
                }
            }
        };

        
        const diasOrdenados = [];

       
        dias.each((i, element) => {
            const $element = $(element);

            
            const data = $element.find('.linha_data_lua .float-left').text().trim();
            if (!data) {
                console.log('Data não encontrada para o elemento:', i);
                return;
            }

            
            const dia = data.split(' - ')[0].trim();
            const mes = 2; // Fevereiro (ajuste conforme necessário)

            // Extrai as marés
            const mares = {};
            $element.find('.celula_mare, .celula_mare_baixa').each((i, el) => {
                const texto = $(el).text().trim();
                // Usa regex para extrair horário e altura (ex: "01:04h 0.1m")
                const match = texto.match(/(\d{2}:\d{2})h\s+([\d.]+m)/);
                if (match) {
                    const tipo = $(el).hasClass('celula_mare') ? 'alta' : 'baixa';
                    mares[`${i + 1}${tipo}`] = `${match[1]}h - ${match[2]}`;
                }
            });

            
            diasOrdenados.push({ dia, mares });
        });

        
        diasOrdenados.sort((a, b) => parseInt(a.dia) - parseInt(b.dia));

        
        diasOrdenados.forEach(({ dia, mares }) => {
            dados.noronha[2025][2][dia] = mares;
        });

        
        const ordenarChaves = (obj) => {
            const ordenado = {};
            Object.keys(obj)
                .sort((a, b) => parseInt(a) - parseInt(b))
                .forEach((chave) => {
                    ordenado[chave] = obj[chave];
                });
            return ordenado;
        };

        // Ordena as chaves do mês 2
        dados.noronha[2025][2] = ordenarChaves(dados.noronha[2025][2]);

        // Salva os dados em um arquivo JSON
        fs.writeFileSync('mares_export.json', JSON.stringify(dados, null, 2));
        console.log('Arquivo JSON salvo com sucesso: mares_export.json');

        await browser.close();
    } catch (error) {
        console.error('Erro ao processar a requisição:', error.message);
        await browser.close();
    }
}

getMare();