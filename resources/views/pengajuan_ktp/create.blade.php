<form action="{{ route('pengajuan_ktp.store') }}" method="POST">
    @csrf
    <div>
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" required>
    </div>
    <div>
        <label for="birthPlace">Birth Place</label>
        <input type="text" id="birthPlace" name="birthPlace" required>
    </div>
    <div>
        <label for="birthDate">Birth Date</label>
        <input type="date" id="birthDate" name="birthDate" required>
    </div>
    <div>
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" required>
    </div>
    <div>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
    </div>
    <div>
        <label for="rtRw">RT/RW:</label>
        <input type="text" id="rtRw" name="rtRw" required>
    </div>
    <div>
        <label for="village">Village:</label>
        <input type="text" id="village" name="village" required>
    </div>
    <div>
        <label for="subdistrict">Subdistrict:</label>
        <input type="text" id="subdistrict" name="subdistrict" required>
    </div>
    <div>
        <label for="religion">Religion:</label>
        <input type="text" id="religion" name="religion" required>
    </div>
    <div>
        <label for="maritalStatus">Marital Status:</label>
        <input type="text" id="maritalStatus" name="maritalStatus" required>
    </div>
    <div>
        <label for="occupation">Occupation:</label>
        <input type="text" id="occupation" name="occupation" required>
    </div>
    <div>
        <label for="citizenship">Citizenship:</label>
        <input type="text" id="citizenship" name="citizenship" required>
    </div>
    <div>
        <label for="bloodType">Blood Type:</label>
        <input type="text" id="bloodType" name="bloodType" required>
    </div>
    
    
    <button type="submit">Submit KTP Application</button>
</form>
