<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartment Lease Contract</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h1, h2 {
            text-align: center;
        }
        p {
            text-align: justify;
        }
        .signature {
            margin-top: 50px;
        }
        .signatures-section {
            display: flex;
            justify-content: space-between;
        }
        .signatures-section div {
            width: 45%;
            text-align: center;
        }
        .acknowledgment {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <h1>APARTMENT LEASE CONTRACT</h1>
    <p>KNOWN ALL MEN BY THESE PRESENTS:</p>
    <p>This Apartment Lease Contract is entered by and between:</p>
    <p>
        <strong>{{ $data['landlord_name'] }}</strong>, 
        of legal age, with residence and postal address at <strong>{{ $data['address'] }}</strong>, hereinafter referred to as the <strong>LESSOR</strong>;
    </p>
    <p>
        -and-
    </p>
    <p>
        <strong>{{ $data['tenant_name'] }}</strong>, hereinafter referred to as the <strong>LESSEE</strong>.
    </p>

    <h2>WITNESSETH:</h2>
    <p>WHEREAS, the LESSOR is the owner of an apartment located at <strong>{{ $data['address'] }}</strong>;</p>
    <p>WHEREAS, the LESSEE is desirous of renting the aforementioned apartment for residential purposes;</p>
    <p>WHEREAS, the LESSOR and LESSEE have mutually agreed to lease the said apartment, subject to the following terms and conditions:</p>

    <h2>TERMS AND CONDITIONS</h2>

    <p>
        <strong>1. LEASE DURATION:</strong> The lease period shall commence on <strong>{{ \Carbon\Carbon::parse($data['start_date'])->format('F j, Y') }}
        </strong> and shall end on <strong>{{ \Carbon\Carbon::parse($data['rental_period'])->format('F j, Y') }}</strong>.
    </p>
    <p>
        <strong>2. MONTHLY RENTAL:</strong> The LESSEE shall pay the monthly rent of <strong>{{ number_format($data['rent_amount'], 2) }} pesos</strong>, due on the 1st of each month at the residence of the LESSOR or via bank transfer.
    </p>
    <p>
        <strong>3. USE OF PREMISES:</strong> The premises shall be used strictly for residential purposes. No business or commercial activity is allowed.
    </p>
    <p>
        <strong>4. MAINTENANCE:</strong> The LESSEE shall maintain the apartment in good, clean, and habitable condition and comply with all local and national laws and regulations.
    </p>
    <p>
        <strong>5. IMPROVEMENTS:</strong> The LESSEE shall not make any structural changes, additions, or alterations to the apartment without prior written consent from the LESSOR.
    </p>
    <p>
        <strong>6. UTILITIES:</strong> The LESSEE shall be responsible for their own utility expenses, including but not limited to electricity, water, and telephone services.
    </p>
    <p>
        <strong>7. INSPECTION OF PREMISES:</strong> The LESSOR reserves the right to inspect the apartment at reasonable times with prior notice to the LESSEE.
    </p>
    <p>
        <strong>8. SUBLEASE OR ASSIGNMENT:</strong> The LESSEE shall not sublease the apartment or assign this lease agreement without the prior written consent of the LESSOR.
    </p>
    <p>
        <strong>9. DAMAGE TO PROPERTY:</strong> The LESSEE shall be responsible for any damage caused to the property due to negligence, except for normal wear and tear.
    </p>
    <p>
        <strong>10. TERMINATION:</strong> Either party may terminate this lease with 30 days' written notice. In case of a breach of contract, the LESSOR reserves the right to terminate the lease agreement with immediate effect.
    </p>

    <h2>IN WITNESS WHEREOF</h2>
    <p>The parties have hereunto set their hands on this ___________ day of ___________ at <strong>{{ $data['address'] }}</strong>.</p>

    <div class="signatures-section">
        <div>
            <p><strong>{{ $data['landlord_name'] }}</strong></p>
            <p>LESSOR</p>
        </div>
        <div>
            <p><strong>{{ $data['tenant_name'] }}</strong></p>
            <p>LESSEE</p>
        </div>
    </div>

    <h2 class="acknowledgment">ACKNOWLEDGMENT</h2>
    <p>BEFORE ME, this ___________ at <strong>{{ $data['address'] }}</strong>, personally appeared the above-named parties, who are known to me to be the same persons who executed the foregoing instrument and acknowledged to me that this was their free and voluntary act and deed.</p>

    <p>WITNESS MY HAND AND SEAL, this ___________ at <strong>{{ $data['address'] }}</strong>.</p>
</body>
</html>
